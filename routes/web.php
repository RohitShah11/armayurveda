<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Public routes
Route::get('/', function(){
    return view('front.index');
})->name('index');
Route::get('/plan', function () {
    return view('front.plan');
})->name('plan');
Route::get('/about', function () {
    return view('front.about');
})->name('about');
Route::get('/products', function () {
    return view('front.products');
})->name('products');
Route::get('/gallery', function () {
    return view('front.gallery');
})->name('gallery');
Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Route::get('/mail', [App\Http\Controllers\BulkEmailController::class, 'sendBulkMail'])->name('mail');

Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/members', [AdminDashboardController::class, 'members'])->name('members.index');
        Route::get('/members/{member}', [AdminDashboardController::class, 'showMember'])->name('members.show');
        Route::patch('/members/{member}/status', [AdminDashboardController::class, 'updateMemberStatus'])->name('members.status');
        Route::patch('/members/{member}/password', [AdminDashboardController::class, 'resetMemberPassword'])->name('members.password');
        Route::get('/kyc', [AdminDashboardController::class, 'kycs'])->name('kyc.index');
        Route::patch('/kyc/{kyc}', [AdminDashboardController::class, 'updateKyc'])->name('kyc.update');
        Route::get('/transactions', [AdminDashboardController::class, 'transactions'])->name('transactions.index');
        Route::get('/earn-transactions', [AdminDashboardController::class, 'earningTransactions'])->name('earn-transactions.index');
        Route::get('/package-purchases', [AdminDashboardController::class, 'packagePurchases'])->name('package-purchases.index');
        Route::get('/zenith-pool', [AdminDashboardController::class, 'zenithPool'])->name('zenith-pool.index');
        Route::get('/zenith-pool/tree', [AdminDashboardController::class, 'zenithPoolTree'])->name('zenith-pool.tree');
        Route::get('/funds', [AdminDashboardController::class, 'funds'])->name('funds.index');
        Route::patch('/funds/{fund}', [AdminDashboardController::class, 'updateFund'])->name('funds.update');
    });
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile',  [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/kyc',       [DashboardController::class, 'kyc'])->name('kyc');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password',[ProfileController::class, 'updatePassword'])->name('change.password.update');
    Route::get('/kyc', [ProfileController::class, 'kyc'])->name('kyc');
    Route::post('/kyc/update', [ProfileController::class, 'updateKyc'])->name('kyc.update');

    // Package
    Route::get('/package/purchase', [DashboardController::class, 'packagePurchase'])->name('package.purchase');
    Route::post('/package/purchase', [DashboardController::class, 'storePackagePurchase'])->name('package.purchase.store');

    // Recharge
    Route::get('/recharge/mobile', [DashboardController::class, 'rechargeMobile'])->name('recharge.mobile');
    Route::get('/recharge/dth',    [DashboardController::class, 'rechargeDth'])->name('recharge.dth');

    // Team
    Route::get('/team/add-member', [MemberController::class, 'create'])->name('team.add-member');
    Route::post('/team/add-member', [MemberController::class, 'store'])->name('team.add-member.post');

    Route::get('/team/direct',      [MemberController::class, 'memberList'])->name('team.direct');
    Route::get('/team/member/{id}', [MemberController::class,'memberDetails'])->name('team.member.details');
    Route::get('/team/level',       [DashboardController::class, 'levelTeam'])->name('team.level');

    // Reports
    Route::get('/report/main-wallet',  [DashboardController::class, 'mainWallet'])->name('report.main-wallet');
    Route::get('/report/earn-wallet',  [DashboardController::class, 'earnWallet'])->name('report.earn-wallet');
    Route::get('/report/package',      [DashboardController::class, 'packageReport'])->name('report.package');
    Route::get('/report/recharge',     [DashboardController::class, 'rechargeReport'])->name('report.recharge');
    Route::get('/report/orders',       [DashboardController::class, 'orderReport'])->name('report.orders');

    // Fund
    Route::get('/fund/request',[ProfileController::class,'fundRequest'])->name('fund.request');
    Route::post('/fund-request/store',[ProfileController::class,'storeFundRequest'])->name('fund.request.store');
    Route::get('/fund/report',   [ProfileController::class, 'fundRequestList'])->name('fund.report');

    // Payout
    Route::get('/payout/request',  [DashboardController::class, 'payoutRequest'])->name('payout.request');
    Route::post('/payout/request', [DashboardController::class, 'storePayoutRequest'])->name('payout.request.post');
    Route::get('/payout/list',     [DashboardController::class, 'payoutList'])->name('payout.list');

    // Income
    Route::get('/income/startup',              [DashboardController::class, 'incomeStartup'])->name('income.startup');
    Route::get('/income/recharge-cashback',    [DashboardController::class, 'incomeRechargeCashback'])->name('income.recharge-cashback');
    Route::get('/income/zenith-benefit',       [DashboardController::class, 'incomeZenithBenefit'])->name('income.zenith-benefit');
    Route::get('/income/product-repurchase',   [DashboardController::class, 'incomeProductRepurchase'])->name('income.product-repurchase');
    Route::get('/income/zenith-pool',          [DashboardController::class, 'incomeZenithPool'])->name('income.zenith-pool');
    Route::get('/income/non-working-pool',     [DashboardController::class, 'incomeNonWorkingPool'])->name('income.non-working-pool');
    Route::get('/income/zenith-team',          [DashboardController::class, 'incomeZenithTeam'])->name('income.zenith-team');
    Route::get('/income/sponsor-pool',         [DashboardController::class, 'incomeSponsorPool'])->name('income.sponsor-pool');
    Route::get('/income/business-expansion',   [DashboardController::class, 'incomeBusinessExpansion'])->name('income.business-expansion');
    Route::get('/income/zenith-package',       [DashboardController::class, 'zenithPackage'])->name('income.zenith-package');

    // Other
    Route::get('/sportmortex', [DashboardController::class, 'sportmortex'])->name('sportmortex');
});
