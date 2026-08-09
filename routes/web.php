<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PayoutController as AdminPayoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkEmailController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProductController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('front.index');
})->name('index');
Route::get('/plan', function () {
    return view('front.plan');
})->name('plan');
Route::get('/about', function () {
    return view('front.about');
})->name('about');
Route::get('/products', [PublicProductController::class, 'index'])->name('products');
Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');
Route::get('/gallery', function () {
    return view('front.gallery');
})->name('gallery');
Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Route::get('/mail', [BulkEmailController::class, 'sendBulkMail'])->name('mail');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/register/sponsor', [AuthController::class, 'lookupSponsor'])
    ->middleware('throttle:60,1')
    ->name('register.sponsor');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
        Route::get('/sponsor-pool', [AdminDashboardController::class, 'sponsorPool'])->name('sponsor-pool.index');
        Route::get('/sponsor-pool/tree', [AdminDashboardController::class, 'sponsorPoolTree'])->name('sponsor-pool.tree');
        Route::get('/direct-tree', [AdminDashboardController::class, 'directTree'])->name('direct-tree.index');
        Route::get('/direct-tree/tree', [AdminDashboardController::class, 'directTreeView'])->name('direct-tree.tree');
        Route::get('/rank-rewards', [AdminDashboardController::class, 'rankRewards'])->name('rank-rewards.index');
        Route::get('/funds', [AdminDashboardController::class, 'funds'])->name('funds.index');
        Route::patch('/funds/{fund}', [AdminDashboardController::class, 'updateFund'])->name('funds.update');
        Route::get('/payouts', [AdminPayoutController::class, 'index'])->name('payouts.index');
        Route::patch('/payouts/{payoutRequest}', [AdminPayoutController::class, 'update'])->name('payouts.update');
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('products', ProductController::class)->except('show');
        Route::get('/product-orders', [ProductOrderController::class, 'index'])->name('product-orders.index');
        Route::patch('/product-orders/{productOrder}', [ProductOrderController::class, 'update'])->name('product-orders.update');
    });
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/kyc', [DashboardController::class, 'kyc'])->name('kyc');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('change.password.update');
    Route::get('/kyc', [ProfileController::class, 'kyc'])->name('kyc');
    Route::post('/kyc/update', [ProfileController::class, 'updateKyc'])->name('kyc.update');

    // Package
    Route::get('/package/purchase', [DashboardController::class, 'packagePurchase'])->name('package.purchase');
    Route::post('/package/purchase', [DashboardController::class, 'storePackagePurchase'])->name('package.purchase.store');
    Route::get('/package/purchases/{packagePurchase}/invoice', [DashboardController::class, 'packageInvoice'])->name('package.purchase.invoice');

    // Recharge
    Route::get('/recharge/mobile', [DashboardController::class, 'rechargeMobile'])->name('recharge.mobile');
    Route::get('/recharge/dth', [DashboardController::class, 'rechargeDth'])->name('recharge.dth');

    // Team
    Route::get('/team/add-member', [MemberController::class, 'create'])->name('team.add-member');
    Route::post('/team/add-member', [MemberController::class, 'store'])->name('team.add-member.post');

    Route::get('/team/direct', [MemberController::class, 'memberList'])->name('team.direct');
    Route::get('/team/member/{id}', [MemberController::class, 'memberDetails'])->name('team.member.details');
    Route::get('/team/level', [DashboardController::class, 'levelTeam'])->name('team.level');

    // Reports
    Route::get('/report/main-wallet', [DashboardController::class, 'mainWallet'])->name('report.main-wallet');
    Route::get('/report/earn-wallet', [DashboardController::class, 'earnWallet'])->name('report.earn-wallet');
    Route::get('/report/package', [DashboardController::class, 'packageReport'])->name('report.package');
    Route::get('/report/recharge', [DashboardController::class, 'rechargeReport'])->name('report.recharge');
    Route::get('/report/orders', [DashboardController::class, 'orderReport'])->name('report.orders');

    // Fund
    Route::get('/fund/request', [ProfileController::class, 'fundRequest'])->name('fund.request');
    Route::post('/fund-request/store', [ProfileController::class, 'storeFundRequest'])->name('fund.request.store');
    Route::get('/fund/report', [ProfileController::class, 'fundRequestList'])->name('fund.report');

    // Payout
    Route::get('/payout/request', [PayoutController::class, 'create'])->name('payout.request');
    Route::post('/payout/request', [PayoutController::class, 'store'])->name('payout.request.post');
    Route::get('/payout/list', [PayoutController::class, 'index'])->name('payout.list');

    // Income
    Route::get('/income/startup', [DashboardController::class, 'incomeStartup'])->name('income.startup');
    Route::get('/income/recharge-cashback', [DashboardController::class, 'incomeRechargeCashback'])->name('income.recharge-cashback');
    Route::get('/income/zenith-benefit', [DashboardController::class, 'incomeZenithBenefit'])->name('income.zenith-benefit');
    Route::get('/income/product-repurchase', [DashboardController::class, 'incomeProductRepurchase'])->name('income.product-repurchase');
    Route::get('/income/zenith-pool', [DashboardController::class, 'incomeZenithPool'])->name('income.zenith-pool');
    Route::get('/income/non-working-pool', [DashboardController::class, 'incomeNonWorkingPool'])->name('income.non-working-pool');
    Route::get('/income/zenith-team', [DashboardController::class, 'incomeZenithTeam'])->name('income.zenith-team');
    Route::get('/income/sponsor-pool', [DashboardController::class, 'incomeSponsorPool'])->name('income.sponsor-pool');
    Route::get('/income/business-expansion', [DashboardController::class, 'incomeBusinessExpansion'])->name('income.business-expansion');
    Route::get('/income/rank-reward', [DashboardController::class, 'incomeRankReward'])->name('income.rank-reward');
    Route::get('/income/zenith-package', [DashboardController::class, 'zenithPackage'])->name('income.zenith-package');

    // Other
    Route::get('/repurchase', [CatalogController::class, 'categories'])->name('catalog.index');
    Route::get('/repurchase/category/{category:slug}', [CatalogController::class, 'products'])->name('catalog.category');
    Route::get('/repurchase/product/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::post('/repurchase/product/{product:slug}/purchase', [CatalogController::class, 'purchase'])->name('catalog.purchase');
    Route::get('/repurchase-orders', [CatalogController::class, 'orders'])->name('catalog.orders');
    Route::get('/repurchase-orders/{productOrder}/invoice', [CatalogController::class, 'invoice'])->name('catalog.orders.invoice');
    Route::get('/sportmortex', [DashboardController::class, 'sportmortex'])->name('sportmortex');
});
