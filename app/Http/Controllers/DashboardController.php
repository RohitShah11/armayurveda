<?php

namespace App\Http\Controllers;

use App\Models\EarningWalletTransaction;
use App\Models\MainWalletTransaction;
use App\Models\MemberKyc;
use App\Models\Package;
use App\Models\PackageCommissionLevel;
use App\Models\PackagePurchase;
use App\Models\ProductOrder;
use App\Models\SponsorPoolLevelIncome;
use App\Models\SponsorPoolNode;
use App\Models\User;
use App\Models\ZenithPoolLevelIncome;
use App\Models\ZenithPoolNode;
use App\Services\DirectTreeService;
use App\Services\RankRewardService;
use App\Services\SponsorPoolService;
use App\Services\ZenithPoolService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        [$directMembers, $totalTeam] = $this->teamCounts($user);

        $mainTransactions = MainWalletTransaction::query()
            ->where('user_id', $user->id)
            ->latest('transaction_date')
            ->latest('id')
            ->limit(10)
            ->get();

        $earningTransactions = EarningWalletTransaction::query()
            ->where('user_id', $user->id)
            ->latest('transaction_date')
            ->latest('id')
            ->limit(10)
            ->get();

        $recentTransactions = $mainTransactions
            ->map(fn (MainWalletTransaction $transaction) => [
                'date' => $transaction->transaction_date ?? $transaction->created_at,
                'description' => $transaction->particular ?: 'Main wallet transaction',
                'amount' => (float) $transaction->amount,
                'direction' => ucfirst(strtolower($transaction->transaction_type)),
            ])
            ->concat($earningTransactions->map(fn (EarningWalletTransaction $transaction) => [
                'date' => $transaction->transaction_date ?? $transaction->created_at,
                'description' => $transaction->description ?: 'Earning wallet transaction',
                'amount' => (float) $transaction->amount,
                'direction' => ucfirst(strtolower($transaction->type)),
            ]))
            ->sortByDesc(fn (array $transaction) => $transaction['date']?->timestamp ?? 0)
            ->take(6)
            ->values();

        $incomeLabels = [
            // 'Start Up Package Level Commission',
            'Mobile & DTH Recharge Cashback',
            'Zenith Package Return Benefit',
            'Product Repurchase Bonus',
            // 'Monthly Zenith Pool Income',
            'Non-Working Global Pool Income',
            'Zenith Team Package Commission',
            'Sponsor Global Pool Income',
            'Business Expansion Incentive Bonus',
            'Rank & Reward',
        ];

        $incomeSummary = collect($incomeLabels)->mapWithKeys(fn (string $label) => [
            $label => ['label' => $label, 'today' => 0.0, 'total' => 0.0],
        ]);

        EarningWalletTransaction::query()
            ->where('user_id', $user->id)
            ->whereRaw('LOWER(type) = ?', ['credit'])
            ->get()
            ->each(function (EarningWalletTransaction $transaction) use ($incomeSummary) {
                $category = $this->incomeCategory($transaction->description);

                if (! $incomeSummary->has($category)) {
                    $incomeSummary->put($category, ['label' => $category, 'today' => 0.0, 'total' => 0.0]);
                }

                $row = $incomeSummary->get($category);
                $row['total'] += (float) $transaction->amount;
                $transactionDate = $transaction->transaction_date ?? $transaction->created_at;

                if ($transactionDate?->isToday()) {
                    $row['today'] += (float) $transaction->amount;
                }

                $incomeSummary->put($category, $row);
            });

        $latestPackage = PackagePurchase::query()
            ->where('user_id', $user->id)
            ->latest('purchase_date')
            ->latest('id')
            ->first();

        $orderQuery = ProductOrder::query()->where('user_id', $user->id);
        $kyc = Schema::hasTable('member_kycs')
            ? MemberKyc::query()->where('user_id', $user->id)->latest('id')->first()
            : null;

        return view('dashboard.index', [
            'user' => $user,
            'directMembers' => $directMembers,
            'totalTeam' => $totalTeam,
            'levelMembers' => max(0, $totalTeam - $directMembers),
            'activePackage' => $user->package_name ?: $latestPackage?->package_name,
            'totalOrders' => (clone $orderQuery)->count(),
            'totalOrderValue' => (float) (clone $orderQuery)->sum('total_amount'),
            'recentTransactions' => $recentTransactions,
            'incomeSummary' => $incomeSummary->values(),
            'kycStatus' => $kyc?->status ?: 'Not Submitted',
        ]);
    }

    private function teamCounts(User $user): array
    {
        if (! $user->member_id) {
            return [0, 0];
        }

        $sponsorIds = [$user->member_id];
        $seenUserIds = [];
        $seenMemberIds = [$user->member_id => true];
        $directMembers = 0;
        $depth = 0;

        while ($sponsorIds !== []) {
            $members = User::query()
                ->whereIn('sponsor_id', $sponsorIds)
                ->get(['id', 'member_id']);
            $nextSponsorIds = [];

            foreach ($members as $member) {
                if (isset($seenUserIds[$member->id])) {
                    continue;
                }

                $seenUserIds[$member->id] = true;

                if ($depth === 0) {
                    $directMembers++;
                }

                if ($member->member_id && ! isset($seenMemberIds[$member->member_id])) {
                    $seenMemberIds[$member->member_id] = true;
                    $nextSponsorIds[] = $member->member_id;
                }
            }

            $sponsorIds = $nextSponsorIds;
            $depth++;
        }

        return [$directMembers, count($seenUserIds)];
    }

    private function incomeCategory(?string $description): string
    {
        $description = strtolower((string) $description);

        return match (true) {
            str_contains($description, 'sponsor global pool') => 'Sponsor Global Pool Income',
            str_contains($description, 'non-working global pool') => 'Non-Working Global Pool Income',
            str_contains($description, 'rank reward'), str_contains($description, 'leadership') => 'Rank & Reward',
            str_contains($description, 'recharge') => 'Mobile & DTH Recharge Cashback',
            str_contains($description, 'repurchase') => 'Product Repurchase Bonus',
            str_contains($description, 'business expansion') => 'Business Expansion Incentive Bonus',
            str_contains($description, 'return benefit') => 'Zenith Package Return Benefit',
            str_contains($description, 'monthly zenith pool') => 'Monthly Zenith Pool Income',
            str_contains($description, 'team package'),
            str_contains($description, 'level') && str_contains($description, 'zenith') => 'Zenith Team Package Commission',
            str_contains($description, 'level') => 'Start Up Package Level Commission',
            default => 'Other Income',
        };
    }

    // public function profile()     { return view('pages.profile'); }
    public function kyc()
    {
        return view('pages.kyc');
    }
    // public function changePassword() { return view('pages.change-password'); }

    // public function updateProfile(Request $request)
    // {
    //     $request->validate(['name' => 'required|string|max:255']);
    //     auth()->user()->update($request->only(['name','email','state','city','address','nominee']));
    //     return back()->with('success', 'Profile updated successfully.');
    // }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        if (! Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function packagePurchase()
    {
        $user = Auth::user();
        $packages = Package::whereRaw('LOWER(category) = ?', ['zenith'])
            ->orderBy('sort_order')
            ->get();
        $currentPackage = $user?->package_name;
        $purchaseHistory = PackagePurchase::where('user_id', $user?->id)
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->get();
        $hasPurchasedPackage = $purchaseHistory->isNotEmpty();

        return view('pages.basic-package', compact('packages', 'currentPackage', 'purchaseHistory', 'hasPurchasedPackage'));
    }

    public function packageInvoice(Request $request, PackagePurchase $packagePurchase)
    {
        abort_unless($packagePurchase->user_id === $request->user()->id, 403);

        $packagePurchase->load(['package', 'user']);
        $profile = Schema::hasTable('member_profiles') ? $packagePurchase->user->profile()->first() : null;
        $invoiceNumber = 'ARM/PKG/'.$packagePurchase->purchase_date->format('Y').'/'.str_pad((string) $packagePurchase->id, 6, '0', STR_PAD_LEFT);

        return view('pages.package-invoice', compact('packagePurchase', 'profile', 'invoiceNumber'));
    }

    public function storePackagePurchase(Request $request)
    {
        $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
        ]);

        $user = Auth::user();
        $package = Package::findOrFail($request->package_id);

        if (! $user) {
            return redirect()->route('login');
        }

        if (strtolower($package->category) !== 'zenith') {
            return back()->withErrors([
                'package' => 'Only the Zenith Package is available for purchase.',
            ]);
        }

        $price = (float) $package->price;

        return DB::transaction(function () use ($user, $package, $price) {
            $user = User::query()->lockForUpdate()->findOrFail($user->id);

            if (PackagePurchase::where('user_id', $user->id)->exists()) {
                return back()->withErrors([
                    'package' => 'You have already purchased a package. Only one package purchase is allowed per user.',
                ]);
            }

            $openingBalance = (float) ($user->main_wallet ?? 0);

            if ($openingBalance < $price) {
                return back()->withErrors(['package' => 'Insufficient wallet balance to purchase this package.']);
            }

            $closingBalance = $openingBalance - $price;

            $user->update([
                'main_wallet' => $closingBalance,
                'package_name' => $package->name,
            ]);

            $packagePurchase = PackagePurchase::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'package_name' => $package->name,
                'package_price' => $price,
                'status' => 'Completed',
                'purchase_date' => now(),
            ]);

            MainWalletTransaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'Debit',
                'amount' => $price,
                'opening_balance' => $openingBalance,
                'closing_balance' => $closingBalance,
                'particular' => 'Package purchase',
                'remarks' => $package->name,
                'transaction_date' => now(),
            ]);

            app(DirectTreeService::class)->enterFromPurchase($user->fresh(), $packagePurchase);
            app(RankRewardService::class)->processFromPurchase($user->fresh(), $packagePurchase);

            $rewardAmount = 250.00;
            $rewardOpeningBalance = (float) ($user->main_wallet ?? 0);
            $rewardClosingBalance = $rewardOpeningBalance + $rewardAmount;

            $user->update([
                'main_wallet' => $rewardClosingBalance,
            ]);

            MainWalletTransaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'Credit',
                'amount' => $rewardAmount,
                'opening_balance' => $rewardOpeningBalance,
                'closing_balance' => $rewardClosingBalance,
                'particular' => 'Zenith package reward',
                'remarks' => 'Reward for purchasing Zenith package',
                'transaction_date' => now(),
            ]);

            $freshUser = $user->fresh();

            app(ZenithPoolService::class)->enterPool($freshUser, $packagePurchase);
            app(SponsorPoolService::class)->enterSponsorFromPurchase($freshUser, $packagePurchase);

            $commissionLevels = PackageCommissionLevel::query()
                ->where('package_category', $package->category)
                ->orderBy('level')
                ->get()
                ->pluck('commission_amount', 'level')
                ->mapWithKeys(fn ($amount, $level) => [(int) $level => (float) $amount])
                ->toArray();

            if (empty($commissionLevels)) {
                $commissionLevels = match (strtolower($package->category)) {
                    'zenith' => [
                        1 => 300.0,
                        2 => 150.0,
                    ],
                    default => [],
                };
            }

            $currentSponsorId = $user->sponsor_id;

            $currentLevel = 1;

            while ($currentSponsorId && $currentLevel <= 15) {
                $sponsor = User::where('member_id', $currentSponsorId)
                    ->lockForUpdate()
                    ->first();

                if (! $sponsor) {
                    break;
                }

                $commissionAmount = (float) ($commissionLevels[$currentLevel] ?? 0);

                if ($commissionAmount > 0) {
                    $sponsorOpeningBalance = (float) ($sponsor->earning_wallet ?? 0);
                    $sponsorClosingBalance = $sponsorOpeningBalance + $commissionAmount;

                    $sponsor->update([
                        'earning_wallet' => $sponsorClosingBalance,
                    ]);

                    $e = EarningWalletTransaction::create([
                        'user_id' => $sponsor->id,
                        'source_user_id' => $user->id,
                        'package_purchase_id' => $packagePurchase->id,
                        'level' => $currentLevel,
                        'type' => 'Credit',
                        'amount' => $commissionAmount,
                        'opening_balance' => $sponsorOpeningBalance,
                        'closing_balance' => $sponsorClosingBalance,
                        'description' => 'Level '.$currentLevel.' commission for '.$package->name,
                        'reference_no' => 'LEVEL-'.$currentLevel.'-PURCHASE-'.$packagePurchase->id,
                        'transaction_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $currentSponsorId = $sponsor->sponsor_id;
                $currentLevel++;
            }

            return redirect()->route('package.purchase')->with('success', 'Package purchased successfully.');
        });
    }

    public function rechargeMobile()
    {
        return view('pages.recharge-cashback');
    }

    public function rechargeDth()
    {
        return view('pages.recharge-cashback');
    }

    public function addMember()
    {
        return view('pages.add-member');
    }

    public function storeMember(Request $request)
    {
        return back()->with('success', 'Member added!');
    }

    public function directMember()
    {
        return view('pages.direct-member');
    }

    public function levelTeam(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $maxLevels = 15;
        $levelMembers = collect();
        $sponsorIds = $user->member_id ? [$user->member_id] : [];
        $seenUserIds = [];
        $hasMemberProfiles = Schema::hasTable('member_profiles');

        for ($level = 1; $level <= $maxLevels && $sponsorIds !== []; $level++) {
            $members = User::query()
                ->whereIn('sponsor_id', $sponsorIds)
                ->when($hasMemberProfiles, fn ($query) => $query->with('profile'))
                ->orderBy('id')
                ->get();

            $nextSponsorIds = [];

            foreach ($members as $member) {
                if (isset($seenUserIds[$member->id])) {
                    continue;
                }

                $seenUserIds[$member->id] = true;
                if (! $hasMemberProfiles) {
                    $member->setRelation('profile', null);
                }
                $member->setAttribute('team_level', $level);
                $member->setAttribute('package_type', $this->teamPackageType($member->package_name));
                $levelMembers->push($member);

                if ($member->member_id) {
                    $nextSponsorIds[] = $member->member_id;
                }
            }

            $sponsorIds = array_values(array_unique($nextSponsorIds));
        }

        $levelSummary = collect(range(1, $maxLevels))->mapWithKeys(function (int $level) use ($levelMembers) {
            $members = $levelMembers->where('team_level', $level);
            $active = $members->where('package_type', 'Zenith')->count();

            return [$level => [
                'total' => $members->count(),
                'zenith' => $members->where('package_type', 'Zenith')->count(),
                'inactive' => $members->where('package_type', 'Inactive')->count(),
                'active_percentage' => $members->isEmpty() ? 0 : round(($active / $members->count()) * 100, 1),
            ]];
        });

        $totals = [
            'members' => $levelMembers->count(),
            'zenith' => $levelMembers->where('package_type', 'Zenith')->count(),
            'inactive' => $levelMembers->where('package_type', 'Inactive')->count(),
        ];
        $totals['active'] = $totals['zenith'];

        $filteredMembers = $levelMembers
            ->when($request->filled('level'), fn ($members) => $members->where('team_level', (int) $request->level))
            ->when($request->filled('package'), fn ($members) => $members->where('package_type', $request->package))
            ->when($request->filled('search'), function ($members) use ($request) {
                $search = strtolower(trim((string) $request->search));

                return $members->filter(fn (User $member) => str_contains(strtolower(implode(' ', [
                    $member->member_id,
                    $member->name,
                    $member->mobile,
                ])), $search));
            })
            ->values();

        $page = max(1, (int) $request->input('page', 1));
        $perPage = 15;
        $members = new LengthAwarePaginator(
            $filteredMembers->forPage($page, $perPage)->values(),
            $filteredMembers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $nonEmptyLevels = $levelSummary->filter(fn (array $summary) => $summary['total'] > 0);
        $highestLevel = $nonEmptyLevels->keys()->max();
        $largestLevel = $nonEmptyLevels->sortByDesc('total')->keys()->first();
        $smallestLevel = $nonEmptyLevels->sortBy('total')->keys()->first();

        return view('pages.level-team', compact(
            'members',
            'levelSummary',
            'totals',
            'maxLevels',
            'highestLevel',
            'largestLevel',
            'smallestLevel'
        ));
    }

    private function teamPackageType(?string $packageName): string
    {
        $packageName = strtolower(trim((string) $packageName));

        return match (true) {
            str_contains($packageName, 'zenith') => 'Zenith',
            default => 'Inactive',
        };
    }

    public function mainWallet()
    {
        $user = Auth::user();

        $transactions = MainWalletTransaction::query()
            ->where('user_id', $user?->id)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->get();

        $currentBalance = (float) ($user?->main_wallet ?? 0);
        $totalCredit = (float) $transactions->where('transaction_type', 'Credit')->sum('amount');
        $totalDebit = (float) $transactions->where('transaction_type', 'Debit')->sum('amount');

        return view('pages.main-wallet', compact('transactions', 'currentBalance', 'totalCredit', 'totalDebit'));
    }

    public function earnWallet()
    {
        $user = Auth::user();

        $transactions = EarningWalletTransaction::query()
            ->where('user_id', $user?->id)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $currentBalance = (float) ($user?->earning_wallet ?? 0);
        $totalCredit = (float) $transactions->where('type', 'Credit')->sum('amount');
        $totalDebit = (float) $transactions->where('type', 'Debit')->sum('amount');

        return view('pages.earn-wallet', compact('transactions', 'currentBalance', 'totalCredit', 'totalDebit'));
    }

    public function packageReport()
    {
        return view('pages.package-report');
    }

    public function rechargeReport()
    {
        return view('pages.recharge-report');
    }

    public function orderReport()
    {
        return view('pages.order-report');
    }

    public function fundRequest()
    {
        return view('pages.fund-request');
    }

    public function storeFundRequest(Request $request)
    {
        return back()->with('success', 'Fund request submitted!');
    }

    public function fundReport()
    {
        return view('pages.fund-report');
    }

    public function incomeStartup()
    {
        return view('pages.startup-commission');
    }

    public function incomeRechargeCashback()
    {
        return view('pages.recharge-cashback');
    }

    public function incomeZenithBenefit()
    {
        return view('pages.zenith-benefit');
    }

    public function incomeProductRepurchase()
    {
        return view('pages.product-repurchase');
    }

    public function incomeZenithPool()
    {
        return view('pages.zenith-pool');
    }

    public function incomeNonWorkingPool(Request $request, ZenithPoolService $zenithPoolService)
    {
        $user = Auth::user();
        $node = $user
            ? ZenithPoolNode::where('user_id', $user->id)->first()
            : null;

        $incomeByLevel = $node
            ? ZenithPoolLevelIncome::where('zenith_pool_node_id', $node->id)->get()->keyBy('level')
            : collect();

        $incomeStructure = [
            1 => ['amount' => 500.0, 'slots' => 4],
            2 => ['amount' => 1000.0, 'slots' => 16],
            3 => ['amount' => 2000.0, 'slots' => 64],
            4 => ['amount' => 4000.0, 'slots' => 256],
            5 => ['amount' => 8000.0, 'slots' => 1024],
            6 => ['amount' => 16000.0, 'slots' => 4096],
        ];

        $levelRows = collect($incomeStructure)->map(function (array $config, int $level) use ($node, $incomeByLevel, $zenithPoolService) {
            $income = $incomeByLevel->get($level);
            $filledSlots = $node ? $zenithPoolService->filledSlotsAtLevel($node, $level) : 0;

            return [
                'level' => $level,
                'amount' => $config['amount'],
                'slots_required' => $config['slots'],
                'filled_slots' => min($filledSlots, $config['slots']),
                'income' => $income,
                'status' => $income ? 'Paid' : 'Pending',
            ];
        })->values();

        $filteredLevelRows = $levelRows
            ->when($request->filled('level'), fn ($rows) => $rows->where('level', (int) $request->level))
            ->when($request->filled('status'), fn ($rows) => $rows->where('status', $request->status))
            ->when($request->filled('from_date'), function ($rows) use ($request) {
                return $rows->filter(fn ($row) => ! $row['income'] || $row['income']->paid_at?->toDateString() >= $request->from_date);
            })
            ->when($request->filled('to_date'), function ($rows) use ($request) {
                return $rows->filter(fn ($row) => ! $row['income'] || $row['income']->paid_at?->toDateString() <= $request->to_date);
            })
            ->values();

        $totalIncome = (float) $incomeByLevel->sum('amount');
        $thisMonthIncome = (float) $incomeByLevel
            ->filter(fn ($income) => $income->paid_at?->isSameMonth(now()))
            ->sum('amount');
        $unlockedLevels = $incomeByLevel->count();
        $nextLevel = $unlockedLevels < 6 ? $unlockedLevels + 1 : null;

        return view('pages.non-working-pool', compact(
            'user',
            'node',
            'levelRows',
            'filteredLevelRows',
            'totalIncome',
            'thisMonthIncome',
            'unlockedLevels',
            'nextLevel'
        ));
    }

    public function incomeZenithTeam(Request $request)
    {
        $user = $request->user();
        $commissionStructure = PackageCommissionLevel::query()
            ->whereRaw('LOWER(package_category) = ?', ['zenith'])
            ->orderBy('level')
            ->get();

        $totalLevels = (int) ($commissionStructure->max('level') ?? 0);
        $planCommission = (float) $commissionStructure->sum('commission_amount');

        $baseQuery = EarningWalletTransaction::query()
            ->where('user_id', $user->id)
            ->whereRaw('LOWER(type) = ?', ['credit'])
            ->whereRaw('LOWER(description) LIKE ?', ['level % commission for %zenith%']);

        $totalIncome = (float) (clone $baseQuery)->sum('amount');
        $thisMonthIncome = (float) (clone $baseQuery)
            ->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');
        $activeLevels = (clone $baseQuery)
            ->select(['level', 'description'])
            ->distinct()
            ->get()
            ->map(fn (EarningWalletTransaction $transaction) => $transaction->commissionLevel())
            ->filter()
            ->unique()
            ->count();
        $totalTeamSales = (clone $baseQuery)->count();

        $transactionsQuery = (clone $baseQuery)
            ->with(['sourceUser', 'packagePurchase']);

        if ($request->filled('from_date')) {
            $transactionsQuery->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $transactionsQuery->whereDate('transaction_date', '<=', $request->to_date);
        }

        if ($request->filled('level')) {
            $level = (int) $request->level;
            $transactionsQuery->where(function ($query) use ($level) {
                $query->where('level', $level)
                    ->orWhere('description', 'like', 'Level '.$level.' commission for %');
            });
        }

        $transactions = $transactionsQuery
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('pages.zenith-team', compact(
            'user',
            'commissionStructure',
            'totalLevels',
            'planCommission',
            'totalIncome',
            'thisMonthIncome',
            'activeLevels',
            'totalTeamSales',
            'transactions'
        ));
    }

    public function incomeSponsorPool(Request $request, SponsorPoolService $sponsorPoolService)
    {
        /** @var User $user */
        $user = Auth::user();

        $entriesQuery = SponsorPoolNode::query()
            ->where('user_id', $user->id)
            ->whereNotNull('purchaser_id')
            ->with(['purchaser', 'packagePurchase', 'levelIncomes'])
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('joined_at', '>=', $request->from_date))
            ->when($request->filled('to_date'), fn ($query) => $query->whereDate('joined_at', '<=', $request->to_date))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('id', $search)
                        ->orWhereHas('purchaser', function ($purchaser) use ($search) {
                            $purchaser->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status === 'paid', fn ($query) => $query->has('levelIncomes'))
            ->when($request->status === 'progress', fn ($query) => $query->whereDoesntHave('levelIncomes', fn ($income) => $income->where('level', 6)));

        $entries = $entriesQuery
            ->latest('joined_at')
            ->latest('id')
            ->paginate(10, ['*'], 'entries_page')
            ->withQueryString();

        $entryProgress = $entries->getCollection()->mapWithKeys(
            fn (SponsorPoolNode $node) => [$node->id => $sponsorPoolService->progressForNode($node)]
        );

        $incomes = SponsorPoolLevelIncome::query()
            ->where('user_id', $user->id)
            ->with(['node.purchaser', 'node.packagePurchase'])
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('paid_at', '>=', $request->from_date))
            ->when($request->filled('to_date'), fn ($query) => $query->whereDate('paid_at', '<=', $request->to_date))
            ->when($request->filled('level'), fn ($query) => $query->where('level', $request->level))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('node', function ($node) use ($search) {
                    $node->where('id', $search)
                        ->orWhereHas('purchaser', function ($purchaser) use ($search) {
                            $purchaser->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('paid_at')
            ->latest('id')
            ->paginate(10, ['*'], 'income_page')
            ->withQueryString();

        $totalPoolIncome = (float) SponsorPoolLevelIncome::where('user_id', $user->id)->sum('amount');
        $totalEntries = SponsorPoolNode::where('user_id', $user->id)->whereNotNull('purchaser_id')->count();
        $completedPayouts = SponsorPoolLevelIncome::where('user_id', $user->id)->count();
        $activeEntries = SponsorPoolNode::where('user_id', $user->id)
            ->whereNotNull('purchaser_id')
            ->whereDoesntHave('levelIncomes', fn ($income) => $income->where('level', 6))
            ->count();
        $incomePlan = $sponsorPoolService->incomePlan();

        return view('pages.sponsor-pool', compact(
            'entries',
            'entryProgress',
            'incomes',
            'totalPoolIncome',
            'totalEntries',
            'completedPayouts',
            'activeEntries',
            'incomePlan'
        ));
    }

    public function incomeBusinessExpansion()
    {
        return view('pages.business-expansion');
    }

    public function incomeRankReward(RankRewardService $rankRewardService)
    {
        $user = Auth::user();
        $progress = $user
            ? $rankRewardService->progressFor($user)
            : ['business' => 0, 'current_rank' => null, 'next_rank' => null, 'remaining' => 0];
        $rankRewards = $user
            ? $user->rankRewards()->orderByDesc('rank')->get()
            : collect();
        $rankPlan = $rankRewardService->ranks();

        return view('pages.rank-reward', compact('progress', 'rankRewards', 'rankPlan'));
    }

    public function zenithPackage()
    {
        return view('pages.zenith-package');
    }

    public function products()
    {
        return view('pages.products');
    }

    public function plan()
    {
        return view('pages.plan');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sportmortex()
    {
        return view('pages.sportmortex');
    }
}
