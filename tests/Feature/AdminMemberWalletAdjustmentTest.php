<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMemberWalletAdjustmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_credit_main_wallet_and_ledger_is_created(): void
    {
        $admin = Admin::create(['name' => 'Admin', 'email' => 'admin@example.com', 'mobile' => '9000000000', 'password' => 'password', 'status' => 'Active']);
        $member = User::factory()->create(['main_wallet' => 100, 'earning_wallet' => 50]);

        $this->actingAs($admin, 'admin')->post(route('admin.members.wallet-adjustment', $member), [
            'wallet' => 'main', 'type' => 'Credit', 'amount' => '25.50', 'remarks' => 'Correction',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertSame('125.50', $member->fresh()->main_wallet);
        $this->assertDatabaseHas('main_wallet_transactions', [
            'user_id' => $member->id, 'transaction_type' => 'Credit', 'amount' => 25.50,
            'opening_balance' => 100, 'closing_balance' => 125.50, 'created_by' => $admin->id,
        ]);
    }

    public function test_admin_can_debit_earning_wallet_and_ledger_is_created(): void
    {
        $admin = Admin::create(['name' => 'Admin', 'email' => 'admin2@example.com', 'mobile' => '9000000001', 'password' => 'password', 'status' => 'Active']);
        $member = User::factory()->create(['main_wallet' => 100, 'earning_wallet' => 80]);

        $this->actingAs($admin, 'admin')->post(route('admin.members.wallet-adjustment', $member), [
            'wallet' => 'earning', 'type' => 'Debit', 'amount' => '30', 'remarks' => 'Chargeback',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertSame('50.00', $member->fresh()->earning_wallet);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $member->id, 'type' => 'Debit', 'amount' => 30,
            'opening_balance' => 80, 'closing_balance' => 50,
        ]);
    }

    public function test_debit_cannot_exceed_selected_wallet_balance(): void
    {
        $admin = Admin::create(['name' => 'Admin', 'email' => 'admin3@example.com', 'mobile' => '9000000002', 'password' => 'password', 'status' => 'Active']);
        $member = User::factory()->create(['main_wallet' => 10, 'earning_wallet' => 20]);

        $this->actingAs($admin, 'admin')->post(route('admin.members.wallet-adjustment', $member), [
            'wallet' => 'main', 'type' => 'Debit', 'amount' => '10.01', 'remarks' => 'Too much',
        ])->assertSessionHasErrors('amount');

        $this->assertSame('10.00', $member->fresh()->main_wallet);
        $this->assertDatabaseCount('main_wallet_transactions', 0);
    }
}
