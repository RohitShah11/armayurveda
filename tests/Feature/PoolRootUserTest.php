<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\SponsorPoolLevelIncome;
use App\Models\SponsorPoolNode;
use App\Models\User;
use App\Models\ZenithPoolLevelIncome;
use App\Models\ZenithPoolNode;
use App\Services\SponsorPoolService;
use App\Services\ZenithPoolService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PoolRootUserTest extends TestCase
{
    use RefreshDatabase;

    private User $rootUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rootUser = User::factory()->create([
            'name' => 'Admin Root User',
            'email' => 'root@armayurveda.test',
            'member_id' => 'ARM1000',
            'earning_wallet' => 0,
        ]);
    }

    public function test_zenith_pool_root_and_income_use_the_first_user(): void
    {
        DB::transaction(function () {
            for ($position = 1; $position <= 4; $position++) {
                $user = User::factory()->create();
                app(ZenithPoolService::class)->enterPool($user);
            }
        });

        $root = ZenithPoolNode::whereNull('parent_id')->firstOrFail();

        $this->assertSame($this->rootUser->id, $root->user_id);
        $this->assertSame(500.0, (float) $this->rootUser->fresh()->earning_wallet);
        $this->assertDatabaseHas('zenith_pool_level_incomes', [
            'zenith_pool_node_id' => $root->id,
            'user_id' => $this->rootUser->id,
            'level' => 1,
            'amount' => '500.00',
        ]);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $this->rootUser->id,
            'description' => 'Zenith Non-Working Global Pool Level 1 complete income',
            'amount' => '500.00',
        ]);
        $this->assertSame(1, ZenithPoolLevelIncome::where('user_id', $this->rootUser->id)->count());
        $this->assertDatabaseCount('admin_earning_wallet_transactions', 0);
    }

    public function test_sponsor_pool_root_and_income_use_the_first_user(): void
    {
        $package = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
        ]);
        $sponsor = User::factory()->create();

        DB::transaction(function () use ($package, $sponsor) {
            for ($position = 1; $position <= 4; $position++) {
                $purchaser = User::factory()->create();
                $purchase = PackagePurchase::create([
                    'user_id' => $purchaser->id,
                    'package_id' => $package->id,
                    'package_name' => $package->name,
                    'package_price' => $package->price,
                    'status' => 'Completed',
                    'purchase_date' => now(),
                ]);

                app(SponsorPoolService::class)->enterPool($sponsor, $purchaser, $purchase);
            }
        });

        $root = SponsorPoolNode::whereNull('parent_id')->firstOrFail();

        $this->assertSame($this->rootUser->id, $root->user_id);
        $this->assertSame(500.0, (float) $this->rootUser->fresh()->earning_wallet);
        $this->assertDatabaseHas('sponsor_pool_level_incomes', [
            'sponsor_pool_node_id' => $root->id,
            'user_id' => $this->rootUser->id,
            'level' => 1,
            'amount' => '500.00',
        ]);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $this->rootUser->id,
            'description' => 'Sponsor Global Pool Level 1 complete income',
            'amount' => '500.00',
        ]);
        $this->assertSame(1, SponsorPoolLevelIncome::where('user_id', $this->rootUser->id)->count());
        $this->assertDatabaseCount('admin_earning_wallet_transactions', 0);
    }
}
