<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectTreeNode;
use App\Models\EarningWalletTransaction;
use App\Models\FundRequest;
use App\Models\MainWalletTransaction;
use App\Models\MemberKyc;
use App\Models\PackagePurchase;
use App\Models\SponsorPoolLevelIncome;
use App\Models\SponsorPoolNode;
use App\Models\User;
use App\Models\UserRankReward;
use App\Models\ZenithPoolLevelIncome;
use App\Models\ZenithPoolNode;
use App\Services\RankRewardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMembers' => User::count(),
            'activeMembers' => User::where('package_name', '!=', '')->count(),
            'pendingKyc' => MemberKyc::where('status', 'Pending')->count(),
            'pendingFunds' => FundRequest::where('status', 'Pending')->count(),
            'approvedFundAmount' => FundRequest::where('status', 'Approved')->sum('amount'),
            'recentMembers' => User::latest()->take(6)->get(),
            'recentFunds' => FundRequest::with('user')->latest()->take(6)->get(),
        ]);
    }

    public function members(Request $request)
    {
        $members = User::query()
            ->with(['profile', 'kyc'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('member_id', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function showMember(User $member)
    {
        $member->load(['profile', 'kyc']);

        $mainWalletTransactions = MainWalletTransaction::where('user_id', $member->id)
            ->latest('transaction_date')->latest('id')->take(10)->get();
        $earningWalletTransactions = EarningWalletTransaction::where('user_id', $member->id)
            ->latest('transaction_date')->latest('id')->take(10)->get();

        return view('admin.members.show', compact('member', 'mainWalletTransactions', 'earningWalletTransactions'));
    }

    public function adjustMemberWallet(Request $request, User $member)
    {
        $validated = $request->validate([
            'wallet' => 'required|in:main,earning',
            'type' => 'required|in:Credit,Debit',
            'amount' => 'required|numeric|decimal:0,2|min:0.01|max:9999999999.99',
            'remarks' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($member, $validated) {
            $lockedMember = User::whereKey($member->id)->lockForUpdate()->firstOrFail();
            $walletColumn = $validated['wallet'] === 'main' ? 'main_wallet' : 'earning_wallet';
            $openingBalance = round((float) ($lockedMember->{$walletColumn} ?? 0), 2);
            $amount = round((float) $validated['amount'], 2);

            if ($validated['type'] === 'Debit' && $amount > $openingBalance) {
                throw ValidationException::withMessages([
                    'amount' => 'The debit amount exceeds the available '.($validated['wallet'] === 'main' ? 'main' : 'earning').' wallet balance.',
                ]);
            }

            $closingBalance = round($validated['type'] === 'Credit'
                ? $openingBalance + $amount
                : $openingBalance - $amount, 2);

            $lockedMember->update([$walletColumn => $closingBalance]);
            $adminId = Auth::guard('admin')->id();

            if ($validated['wallet'] === 'main') {
                MainWalletTransaction::create([
                    'user_id' => $lockedMember->id,
                    'transaction_type' => $validated['type'],
                    'amount' => $amount,
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'particular' => 'Manual admin adjustment',
                    'remarks' => $validated['remarks'],
                    'transaction_date' => now(),
                    'created_by' => $adminId,
                ]);
            } else {
                EarningWalletTransaction::create([
                    'user_id' => $lockedMember->id,
                    'type' => $validated['type'],
                    'amount' => $amount,
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'description' => 'Manual admin adjustment: '.$validated['remarks'],
                    'reference_no' => 'ADMIN-'.now()->format('YmdHis').'-'.$lockedMember->id,
                    'transaction_date' => now(),
                ]);
            }
        });

        return back()->with('success', ucfirst($validated['wallet'])." wallet {$validated['type']} of INR ".number_format((float) $validated['amount'], 2).' completed successfully.');
    }

    public function updateMemberStatus(Request $request, User $member)
    {
        $request->validate([
            'status' => 'required|in:Active,Blocked,Inactive',
        ]);

        $member->update(['status' => $request->status]);

        return back()->with('success', 'Member status updated successfully.');
    }

    public function resetMemberPassword(Request $request, User $member)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $member->update(['password' => Hash::make($request->password)]);

        $login = $member->email ?: $member->mobile;

        return back()->with('success', "Member password reset successfully. The member can log in with {$login} and the new password you entered.");
    }

    public function loginAsMember(Request $request, User $member)
    {
        Auth::guard('web')->login($member);
        $request->session()->put('impersonated_by_admin_id', Auth::guard('admin')->id());
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function kycs(Request $request)
    {
        $kycs = MemberKyc::with('user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('member_id', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.kyc.index', compact('kycs'));
    }

    public function updateKyc(Request $request, MemberKyc $kyc)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string|max:500',
        ]);

        $kyc->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "KYC {$request->status} successfully.");
    }

    public function transactions(Request $request)
    {
        $transactions = MainWalletTransaction::query()
            ->with('user')
            ->when($request->filled('type'), fn ($query) => $query->where('transaction_type', $request->type))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('particular', 'like', "%{$search}%")
                        ->orWhere('remarks', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function earningTransactions(Request $request)
    {
        $transactions = EarningWalletTransaction::query()
            ->with('user')
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->type))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('description', 'like', "%{$search}%")
                        ->orWhere('reference_no', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.earn-transactions.index', compact('transactions'));
    }

    public function packagePurchases(Request $request)
    {
        $purchasesQuery = PackagePurchase::query()
            ->with(['user', 'package'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('package'), fn ($query) => $query->where('package_name', $request->package))
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('purchase_date', '>=', $request->from_date))
            ->when($request->filled('to_date'), fn ($query) => $query->whereDate('purchase_date', '<=', $request->to_date))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('package_name', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%");
                        });
                });
            });

        $totalPurchases = (clone $purchasesQuery)->count();
        $totalAmount = (clone $purchasesQuery)->sum('package_price');
        $completedPurchases = (clone $purchasesQuery)->where('status', 'Completed')->count();
        $packageNames = PackagePurchase::query()
            ->whereNotNull('package_name')
            ->distinct()
            ->orderBy('package_name')
            ->pluck('package_name');

        $purchases = $purchasesQuery
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.package-purchases.index', compact(
            'purchases',
            'totalPurchases',
            'totalAmount',
            'completedPurchases',
            'packageNames'
        ));
    }

    public function zenithPool(Request $request)
    {
        $nodesQuery = ZenithPoolNode::query()
            ->with(['user', 'parent.user', 'packagePurchase', 'levelIncomes'])
            ->withCount('children')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('depth'), fn ($query) => $query->where('depth', $request->depth))
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'completed') {
                    $query->has('levelIncomes');
                }

                if ($request->status === 'pending') {
                    $query->doesntHave('levelIncomes');
                }
            });

        $nodes = (clone $nodesQuery)
            ->orderBy('depth')
            ->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        $levelIncomes = ZenithPoolLevelIncome::query()
            ->with('node.user')
            ->latest('paid_at')
            ->latest('id')
            ->take(20)
            ->get();

        $rootNode = ZenithPoolNode::whereNull('parent_id')->with('user')->first();
        $totalNodes = ZenithPoolNode::count();
        $memberNodes = ZenithPoolNode::whereNotNull('parent_id')->count();
        $paidLevels = ZenithPoolLevelIncome::count();
        $totalPaid = (float) ZenithPoolLevelIncome::sum('amount');
        $rootIncome = $rootNode
            ? (float) ZenithPoolLevelIncome::where('zenith_pool_node_id', $rootNode->id)->sum('amount')
            : 0.0;
        $maxDepth = (int) ZenithPoolNode::max('depth');

        $depthStats = ZenithPoolNode::query()
            ->select('depth', DB::raw('count(*) as total'))
            ->groupBy('depth')
            ->orderBy('depth')
            ->get();

        return view('admin.zenith-pool.index', compact(
            'nodes',
            'levelIncomes',
            'rootNode',
            'totalNodes',
            'memberNodes',
            'paidLevels',
            'totalPaid',
            'rootIncome',
            'maxDepth',
            'depthStats'
        ));
    }

    public function zenithPoolTree(Request $request)
    {
        $focusNode = null;

        if ($request->filled('node')) {
            $focusNode = ZenithPoolNode::with('user')->find($request->node);
        }

        $rootNode = $focusNode ?: ZenithPoolNode::whereNull('parent_id')->with('user')->first();
        $tree = $rootNode ? $this->buildZenithPoolTree($rootNode, 0, 4) : null;

        $searchNodes = ZenithPoolNode::query()
            ->with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('depth')
            ->orderBy('id')
            ->take(20)
            ->get();

        $totalNodes = ZenithPoolNode::count();
        $memberNodes = ZenithPoolNode::whereNotNull('parent_id')->count();
        $maxDepth = (int) ZenithPoolNode::max('depth');

        return view('admin.zenith-pool.tree', compact(
            'tree',
            'rootNode',
            'searchNodes',
            'totalNodes',
            'memberNodes',
            'maxDepth'
        ));
    }

    private function buildZenithPoolTree(ZenithPoolNode $node, int $depth, int $maxDepth): array
    {
        $node->loadMissing(['user', 'levelIncomes']);

        $children = [];

        if ($depth < $maxDepth) {
            $actualChildren = ZenithPoolNode::query()
                ->with(['user', 'levelIncomes'])
                ->where('parent_id', $node->id)
                ->orderBy('position')
                ->get()
                ->keyBy('position');

            for ($position = 1; $position <= 4; $position++) {
                $children[] = $actualChildren->has($position)
                    ? $this->buildZenithPoolTree($actualChildren->get($position), $depth + 1, $maxDepth)
                    : [
                        'node' => null,
                        'owner' => null,
                        'label' => 'Empty Slot',
                        'sub_label' => 'Position '.$position,
                        'type' => 'empty',
                        'depth' => $depth + 1,
                        'children' => [],
                    ];
            }
        }

        $owner = $node->user;

        return [
            'node' => $node,
            'owner' => $owner,
            'label' => $owner?->name ?? 'Unknown',
            'sub_label' => $node->user?->member_id ?? $node->user?->email ?? 'Pool Node #'.$node->id,
            'type' => $node->parent_id === null ? 'admin' : 'member',
            'depth' => $depth,
            'children' => $children,
            'completed_levels' => $node->levelIncomes->pluck('level')->sort()->values(),
        ];
    }

    public function sponsorPool(Request $request)
    {
        $nodesQuery = SponsorPoolNode::query()
            ->with(['user', 'purchaser', 'parent.user', 'packagePurchase', 'levelIncomes'])
            ->withCount('children')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('purchaser', function ($purchaserQuery) use ($search) {
                            $purchaserQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('depth'), fn ($query) => $query->where('depth', $request->depth))
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'completed') {
                    $query->has('levelIncomes');
                }

                if ($request->status === 'pending') {
                    $query->doesntHave('levelIncomes');
                }
            });

        $nodes = (clone $nodesQuery)
            ->orderBy('depth')
            ->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        $levelIncomes = SponsorPoolLevelIncome::query()
            ->with('node.user')
            ->latest('paid_at')
            ->latest('id')
            ->take(20)
            ->get();

        $rootNode = SponsorPoolNode::whereNull('parent_id')->with('user')->first();
        $totalNodes = SponsorPoolNode::count();
        $memberNodes = SponsorPoolNode::whereNotNull('parent_id')->count();
        $paidLevels = SponsorPoolLevelIncome::count();
        $totalPaid = (float) SponsorPoolLevelIncome::sum('amount');
        $rootIncome = $rootNode
            ? (float) SponsorPoolLevelIncome::where('sponsor_pool_node_id', $rootNode->id)->sum('amount')
            : 0.0;
        $maxDepth = (int) SponsorPoolNode::max('depth');

        $depthStats = SponsorPoolNode::query()
            ->select('depth', DB::raw('count(*) as total'))
            ->groupBy('depth')
            ->orderBy('depth')
            ->get();

        return view('admin.sponsor-pool.index', compact(
            'nodes',
            'levelIncomes',
            'rootNode',
            'totalNodes',
            'memberNodes',
            'paidLevels',
            'totalPaid',
            'rootIncome',
            'maxDepth',
            'depthStats'
        ));
    }

    public function sponsorPoolTree(Request $request)
    {
        $focusNode = null;

        if ($request->filled('node')) {
            $focusNode = SponsorPoolNode::with(['user', 'purchaser'])->find($request->node);
        }

        $rootNode = $focusNode ?: SponsorPoolNode::whereNull('parent_id')->with(['user', 'purchaser'])->first();
        $tree = $rootNode ? $this->buildSponsorPoolTree($rootNode, 0, 4) : null;

        $searchNodes = SponsorPoolNode::query()
            ->with(['user', 'purchaser'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%");
                        })
                        ->orWhereHas('purchaser', function ($purchaserQuery) use ($search) {
                            $purchaserQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('depth')
            ->orderBy('id')
            ->take(20)
            ->get();

        $totalNodes = SponsorPoolNode::count();
        $memberNodes = SponsorPoolNode::whereNotNull('parent_id')->count();
        $maxDepth = (int) SponsorPoolNode::max('depth');

        return view('admin.sponsor-pool.tree', compact(
            'tree',
            'rootNode',
            'searchNodes',
            'totalNodes',
            'memberNodes',
            'maxDepth'
        ));
    }

    private function buildSponsorPoolTree(SponsorPoolNode $node, int $depth, int $maxDepth): array
    {
        $node->loadMissing(['user', 'purchaser', 'levelIncomes']);

        $children = [];

        if ($depth < $maxDepth) {
            $actualChildren = SponsorPoolNode::query()
                ->with(['user', 'purchaser', 'levelIncomes'])
                ->where('parent_id', $node->id)
                ->orderBy('position')
                ->get()
                ->keyBy('position');

            for ($position = 1; $position <= 4; $position++) {
                $children[] = $actualChildren->has($position)
                    ? $this->buildSponsorPoolTree($actualChildren->get($position), $depth + 1, $maxDepth)
                    : [
                        'node' => null,
                        'owner' => null,
                        'label' => 'Empty Slot',
                        'sub_label' => 'Position '.$position,
                        'type' => 'empty',
                        'depth' => $depth + 1,
                        'children' => [],
                    ];
            }
        }

        $owner = $node->user;

        return [
            'node' => $node,
            'owner' => $owner,
            'label' => $owner?->name ?? 'Unknown',
            'sub_label' => $node->user?->member_id ?? $node->user?->email ?? 'Pool Node #'.$node->id,
            'type' => $node->parent_id === null ? 'admin' : 'member',
            'depth' => $depth,
            'children' => $children,
            'completed_levels' => $node->levelIncomes->pluck('level')->sort()->values(),
        ];
    }

    public function directTree(Request $request)
    {
        $nodesQuery = DirectTreeNode::query()
            ->with(['user.rankRewards', 'parent.user', 'packagePurchase'])
            ->withCount('children')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('depth'), fn ($query) => $query->where('depth', $request->depth));

        $nodes = (clone $nodesQuery)
            ->orderBy('depth')
            ->orderBy('position')
            ->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        $rootNode = DirectTreeNode::whereNull('parent_id')->with('user')->first();
        $totalNodes = DirectTreeNode::count();
        $memberNodes = DirectTreeNode::whereNotNull('parent_id')->count();
        $maxDepth = (int) DirectTreeNode::max('depth');

        $depthStats = DirectTreeNode::query()
            ->select('depth', DB::raw('count(*) as total'))
            ->groupBy('depth')
            ->orderBy('depth')
            ->get();

        return view('admin.direct-tree.index', compact(
            'nodes',
            'rootNode',
            'totalNodes',
            'memberNodes',
            'maxDepth',
            'depthStats'
        ));
    }

    public function directTreeView(Request $request)
    {
        $rootUser = User::query()->orderBy('id')->first();
        $focusUser = null;

        if ($request->filled('member')) {
            $focusUser = User::find($request->member);
        } elseif ($request->filled('node')) {
            // Keep old direct-tree links/bookmarks working.
            $focusUser = DirectTreeNode::with('user')->find($request->node)?->user;
        }

        $focusedUser = $focusUser ?: $rootUser;
        $tree = $focusedUser
            ? $this->buildAllMembersDirectTree($focusedUser, 0, 4, $rootUser?->id)
            : null;

        $searchMembers = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('member_id', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->take(20)
            ->get();

        $totalMembers = User::count();
        $purchasedMembers = User::whereNotNull('package_name')->where('package_name', '!=', '')->count();
        $notPurchasedMembers = $totalMembers - $purchasedMembers;

        return view('admin.direct-tree.tree', compact(
            'tree',
            'focusedUser',
            'searchMembers',
            'totalMembers',
            'purchasedMembers',
            'notPurchasedMembers'
        ));
    }

    private function buildAllMembersDirectTree(User $user, int $depth, int $maxDepth, ?int $rootUserId, array $visited = []): array
    {
        $visited[] = $user->id;

        $children = [];

        if ($depth < $maxDepth) {
            $childrenQuery = User::query()
                ->whereNotIn('id', $visited)
                ->where('id', '!=', $user->id)
                ->where('sponsor_id', $user->member_id);

            if ($user->id === $rootUserId) {
                $childrenQuery->orWhere(function ($query) use ($visited, $user) {
                    $query->whereNotIn('id', $visited)
                        ->where('id', '!=', $user->id)
                        ->where(function ($orphan) {
                            $orphan->whereNull('sponsor_id')
                                ->orWhere('sponsor_id', '')
                                ->orWhereNotIn('sponsor_id', User::query()->whereNotNull('member_id')->select('member_id'));
                        });
                });
            }

            $children = $childrenQuery
                ->orderBy('id')
                ->get()
                ->unique('id')
                ->map(fn (User $child) => $this->buildAllMembersDirectTree($child, $depth + 1, $maxDepth, $rootUserId, $visited))
                ->all();
        }

        $hasPurchased = filled($user->package_name);

        return [
            'user' => $user,
            'label' => $user->name ?: 'Unknown',
            'sub_label' => $user->member_id ?? $user->email ?? 'Member #'.$user->id,
            'has_purchased' => $hasPurchased,
            'depth' => $depth,
            'children' => $children,
        ];
    }

    public function rankRewards(Request $request, RankRewardService $rankRewardService)
    {
        $rewardsQuery = UserRankReward::query()
            ->with('user')
            ->when($request->filled('rank'), fn ($query) => $query->where('rank', $request->rank))
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('qualified_at', '>=', $request->from_date))
            ->when($request->filled('to_date'), fn ($query) => $query->whereDate('qualified_at', '<=', $request->to_date))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($inner) use ($search) {
                    $inner->where('rank_name', 'like', "%{$search}%")
                        ->orWhere('additional_reward', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            });

        $totalRewards = (clone $rewardsQuery)->count();
        $totalPaid = (float) (clone $rewardsQuery)->sum('reward_amount');
        $highestRank = (int) UserRankReward::max('rank');
        $latestRewards = $rewardsQuery
            ->orderByDesc('qualified_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();
        $rankPlan = $rankRewardService->ranks();

        return view('admin.rank-rewards.index', compact(
            'latestRewards',
            'rankPlan',
            'totalRewards',
            'totalPaid',
            'highestRank'
        ));
    }

    public function funds(Request $request)
    {
        $funds = FundRequest::with('user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('transaction_id', 'like', "%{$search}%")
                        ->orWhere('depositor_name', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.funds.index', compact('funds'));
    }

    public function updateFund(Request $request, FundRequest $fund)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'admin_remark' => 'nullable|string|max:500',
        ]);

        if ($fund->status === 'Approved' && $request->status === 'Rejected') {
            return back()->with('error', 'Approved fund requests cannot be rejected from this flow.');
        }

        DB::transaction(function () use ($fund, $request) {
            $adminId = Auth::guard('admin')->id();
            $fund = FundRequest::whereKey($fund->id)->lockForUpdate()->firstOrFail();
            $previousStatus = $fund->status;

            if ($previousStatus === 'Approved' && $request->status === 'Rejected') {
                return;
            }

            $fund->update([
                'status' => $request->status,
                'admin_remark' => $request->admin_remark,
                'approved_by' => $adminId,
                'approved_at' => now(),
            ]);

            if ($request->status !== 'Approved' || $previousStatus === 'Approved' || ! $fund->user) {
                return;
            }

            $user = User::whereKey($fund->user_id)->lockForUpdate()->first();

            if (! $user) {
                return;
            }

            $openingBalance = (float) ($user->main_wallet ?? 0);
            $amount = (float) $fund->amount;
            $closingBalance = $openingBalance + $amount;

            $user->update(['main_wallet' => $closingBalance]);

            MainWalletTransaction::create([
                'user_id' => $user->id,
                'fund_request_id' => $fund->id,
                'transaction_type' => 'Credit',
                'amount' => $amount,
                'opening_balance' => $openingBalance,
                'closing_balance' => $closingBalance,
                'particular' => 'Fund request approved',
                'remarks' => $request->admin_remark,
                'transaction_date' => now(),
                'created_by' => $adminId,
            ]);
        });

        return back()->with('success', "Fund request {$request->status} successfully.");
    }
}
