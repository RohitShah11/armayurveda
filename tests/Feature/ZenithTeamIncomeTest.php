<?php

namespace Tests\Feature;

use App\Models\EarningWalletTransaction;
use App\Models\Package;
use App\Models\PackageCommissionLevel;
use App\Models\PackagePurchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ZenithTeamIncomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_zenith_team_income_page_uses_persisted_commission_records(): void
    {
        Carbon::setTestNow('2026-08-09 12:00:00');

        $member = User::factory()->create([
            'member_id' => 'ARM7000',
            'earning_wallet' => 700,
        ]);
        $buyerOne = User::factory()->create([
            'member_id' => 'ARM7001',
            'name' => 'Buyer One',
            'sponsor_id' => $member->member_id,
        ]);
        $buyerTwo = User::factory()->create([
            'member_id' => 'ARM7002',
            'name' => 'Buyer Two',
            'sponsor_id' => $member->member_id,
        ]);
        $otherMember = User::factory()->create([
            'member_id' => 'ARM7999',
        ]);

        $package = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package-income-test',
            'price' => 5500,
            'category' => 'Zenith',
            'description' => 'Zenith package',
        ]);

        PackageCommissionLevel::create([
            'package_category' => 'Zenith',
            'level' => 1,
            'commission_amount' => 500,
        ]);
        PackageCommissionLevel::create([
            'package_category' => 'Zenith',
            'level' => 2,
            'commission_amount' => 200,
        ]);
        PackageCommissionLevel::create([
            'package_category' => 'Zenith',
            'level' => 3,
            'commission_amount' => 100,
        ]);

        $purchaseOne = $this->purchase($buyerOne, $package, '2026-07-15 10:00:00');
        $purchaseTwo = $this->purchase($buyerTwo, $package, '2026-08-05 10:00:00');

        $this->commission($member, $buyerOne, $purchaseOne, 1, 500, '2026-07-15 10:00:00');
        $this->commission($member, $buyerTwo, $purchaseTwo, 2, 200, '2026-08-05 10:00:00');
        $this->commission($otherMember, $buyerTwo, $purchaseTwo, 1, 500, '2026-08-05 10:00:00');

        EarningWalletTransaction::create([
            'user_id' => $member->id,
            'type' => 'Credit',
            'amount' => 50,
            'opening_balance' => 700,
            'closing_balance' => 750,
            'description' => 'Product repurchase bonus',
            'transaction_date' => now(),
        ]);

        $response = $this->actingAs($member)->get(route('income.zenith-team'));

        $response
            ->assertOk()
            ->assertSee('background:var(--primary);color:#fff', false)
            ->assertDontSee('name="status"', false)
            ->assertDontSee('<th>Status</th>', false)
            ->assertSee('Buyer One')
            ->assertSee('Buyer Two')
            ->assertViewHas('totalLevels', 3)
            ->assertViewHas('planCommission', 800.0)
            ->assertViewHas('totalIncome', 700.0)
            ->assertViewHas('thisMonthIncome', 200.0)
            ->assertViewHas('activeLevels', 2)
            ->assertViewHas('totalTeamSales', 2)
            ->assertViewHas('transactions', fn ($transactions) => $transactions->total() === 2);

        $this->actingAs($member)
            ->get(route('income.zenith-team', ['level' => 2]))
            ->assertOk()
            ->assertSee('Buyer Two')
            ->assertDontSee('Buyer One')
            ->assertViewHas('transactions', fn ($transactions) => $transactions->total() === 1);

        Carbon::setTestNow();
    }

    private function purchase(User $buyer, Package $package, string $date): PackagePurchase
    {
        return PackagePurchase::create([
            'user_id' => $buyer->id,
            'package_id' => $package->id,
            'package_name' => $package->name,
            'package_price' => $package->price,
            'status' => 'Completed',
            'purchase_date' => $date,
        ]);
    }

    private function commission(
        User $recipient,
        User $buyer,
        PackagePurchase $purchase,
        int $level,
        float $amount,
        string $date
    ): EarningWalletTransaction {
        return EarningWalletTransaction::create([
            'user_id' => $recipient->id,
            'source_user_id' => $buyer->id,
            'package_purchase_id' => $purchase->id,
            'level' => $level,
            'type' => 'Credit',
            'amount' => $amount,
            'opening_balance' => 0,
            'closing_balance' => $amount,
            'description' => 'Level '.$level.' commission for Zenith Package',
            'reference_no' => 'LEVEL-'.$level.'-PURCHASE-'.$purchase->id,
            'transaction_date' => $date,
        ]);
    }
}
