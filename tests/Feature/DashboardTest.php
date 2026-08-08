<?php

namespace Tests\Feature;

use App\Models\EarningWalletTransaction;
use App\Models\MainWalletTransaction;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_live_member_account_and_activity_data(): void
    {
        $member = User::factory()->create([
            'name' => 'Dashboard Member',
            'member_id' => 'ARM5001',
            'status' => 'Active',
            'main_wallet' => 12500.50,
            'earning_wallet' => 875.25,
            'package_name' => 'Zenith Package',
        ]);

        $direct = User::factory()->create([
            'member_id' => 'ARM5002',
            'sponsor_id' => $member->member_id,
        ]);

        User::factory()->create([
            'member_id' => 'ARM5003',
            'sponsor_id' => $direct->member_id,
        ]);

        MainWalletTransaction::create([
            'user_id' => $member->id,
            'transaction_type' => 'Debit',
            'amount' => 500,
            'opening_balance' => 13000.50,
            'closing_balance' => 12500.50,
            'particular' => 'Product repurchase',
            'transaction_date' => now()->subHour(),
        ]);

        EarningWalletTransaction::create([
            'user_id' => $member->id,
            'type' => 'Credit',
            'amount' => 300,
            'opening_balance' => 575.25,
            'closing_balance' => 875.25,
            'description' => 'Level 1 commission for Zenith Package',
            'transaction_date' => now(),
        ]);

        ProductOrder::create([
            'order_number' => 'ARM-TEST-0001',
            'user_id' => $member->id,
            'product_name' => 'Test Product',
            'unit_price' => 250,
            'quantity' => 2,
            'total_amount' => 500,
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'ordered_at' => now(),
        ]);

        $response = $this->actingAs($member)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Dashboard Member')
            ->assertSee('₹12,500.50')
            ->assertSee('Zenith Package')
            ->assertSee('Product repurchase')
            ->assertSee(route('team.add-member'), false)
            ->assertViewHas('directMembers', 1)
            ->assertViewHas('totalTeam', 2)
            ->assertViewHas('levelMembers', 1)
            ->assertViewHas('totalOrders', 1)
            ->assertViewHas('totalOrderValue', 500.0)
            ->assertViewHas('incomeSummary', function ($summary) {
                $income = $summary->firstWhere('label', 'Zenith Team Package Commission');

                return $income['today'] === 300.0 && $income['total'] === 300.0;
            });
    }

    public function test_dashboard_uses_safe_empty_states_for_a_new_member(): void
    {
        $member = User::factory()->create([
            'member_id' => 'ARM6001',
            'status' => 'Active',
            'main_wallet' => 0,
            'earning_wallet' => 0,
            'package_name' => null,
        ]);

        $this->actingAs($member)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Not purchased')
            ->assertSee('Not Submitted')
            ->assertSee('No wallet transactions yet.')
            ->assertViewHas('totalTeam', 0)
            ->assertViewHas('totalOrders', 0);
    }
}
