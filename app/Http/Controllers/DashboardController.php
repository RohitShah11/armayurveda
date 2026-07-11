<?php

namespace App\Http\Controllers;

use App\Models\MainWalletTransaction;
use App\Models\EarningWalletTransaction;
use App\Models\Package;
use App\Models\PackageCommissionLevel;
use App\Models\PackagePurchase;
use App\Models\User;
use App\Models\ZenithPoolLevelIncome;
use App\Models\ZenithPoolNode;
use App\Services\ZenithPoolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()       { return view('dashboard.index'); }
    //public function profile()     { return view('pages.profile'); }
    public function kyc()         { return view('pages.kyc'); }
    //public function changePassword() { return view('pages.change-password'); }

    // public function updateProfile(Request $request)
    // {
    //     $request->validate(['name' => 'required|string|max:255']);
    //     auth()->user()->update($request->only(['name','email','state','city','address','nominee']));
    //     return back()->with('success', 'Profile updated successfully.');
    // }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:6|confirmed',
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully.');
    }

    public function packagePurchase()
    {
        $user = Auth::user();
        $packages = Package::orderBy('sort_order')->get();
        $currentPackage = $user?->package_name;
        $purchaseHistory = PackagePurchase::where('user_id', $user?->id)
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->get();

        return view('pages.basic-package', compact('packages', 'currentPackage', 'purchaseHistory'));
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

        $walletBalance = (float) ($user->main_wallet ?? 0);
        $price = (float) $package->price;

        if ($walletBalance < $price) {
            return back()->withErrors(['package' => 'Insufficient wallet balance to purchase this package.']);
        }

        return DB::transaction(function () use ($user, $package, $price, $walletBalance) {
            $openingBalance = $walletBalance;
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

            if (strtolower($package->category) === 'zenith') {
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

                app(ZenithPoolService::class)->enterPool($user->fresh(), $packagePurchase);
            }

            $commissionLevels = PackageCommissionLevel::query()
                ->where('package_category', $package->category)
                ->orderBy('level')
                ->get()
                ->pluck('commission_amount', 'level')
                ->mapWithKeys(fn ($amount, $level) => [(int) $level => (float) $amount])
                ->toArray();

            if (empty($commissionLevels)) {
                $commissionLevels = match (strtolower($package->category)) {
                    'basic' => [
                        1 => 200.0,
                        2 => 100.0,
                    ],
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
                $sponsor = User::where('member_id', $currentSponsorId)->first();
                
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
                        'type' => 'Credit',
                        'amount' => $commissionAmount,
                        'opening_balance' => $sponsorOpeningBalance,
                        'closing_balance' => $sponsorClosingBalance,
                        'description' => 'Level '.$currentLevel.' commission for '.$package->name,
                        'reference_no' => 'LEVEL-'.$currentLevel.'-'.$package->id.'-'.now()->timestamp,
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
    public function rechargeMobile()     { return view('pages.recharge-cashback'); }
    public function rechargeDth()        { return view('pages.recharge-cashback'); }
    public function addMember()          { return view('pages.add-member'); }
    public function storeMember(Request $request) { return back()->with('success', 'Member added!'); }
    public function directMember()       { return view('pages.direct-member'); }
    public function levelTeam()          { return view('pages.level-team'); }
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
    public function packageReport()      { return view('pages.package-report'); }
    public function rechargeReport()     { return view('pages.recharge-report'); }
    public function orderReport()        { return view('pages.order-report'); }
    public function fundRequest()        { return view('pages.fund-request'); }
    public function storeFundRequest(Request $request) { return back()->with('success', 'Fund request submitted!'); }
    public function fundReport()         { return view('pages.fund-report'); }
    public function payoutRequest()      { return view('pages.payout'); }
    public function storePayoutRequest(Request $request) { return back()->with('success', 'Payout request submitted!'); }
    public function payoutList()         { return view('pages.payout-list'); }
    public function incomeStartup()      { return view('pages.startup-commission'); }
    public function incomeRechargeCashback() { return view('pages.recharge-cashback'); }
    public function incomeZenithBenefit()    { return view('pages.zenith-benefit'); }
    public function incomeProductRepurchase(){ return view('pages.product-repurchase'); }
    public function incomeZenithPool()       { return view('pages.zenith-pool'); }
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
    public function incomeZenithTeam()       { return view('pages.zenith-team'); }
    public function incomeSponsorPool()      { return view('pages.sponsor-pool'); }
    public function incomeBusinessExpansion(){ return view('pages.business-expansion'); }
    public function zenithPackage()      { return view('pages.zenith-package'); }
    public function products()           { return view('pages.products'); }
    public function plan()               { return view('pages.plan'); }
    public function gallery()            { return view('pages.gallery'); }
    public function about()              { return view('pages.about'); }
    public function contact()            { return view('pages.contact'); }
    public function sportmortex()        { return view('pages.sportmortex'); }
}
