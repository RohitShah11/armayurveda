<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\MemberKyc;
use App\Models\PayoutRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_without_active_package_cannot_request_payout(): void
    {
        $member = $this->member(['package_name' => null]);
        $this->approvedKyc($member);

        $this->actingAs($member)
            ->post(route('payout.request.post'), $this->validPayload())
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseCount('payout_requests', 0);
        $this->assertSame(2000.0, (float) $member->fresh()->earning_wallet);
    }

    public function test_member_without_approved_kyc_cannot_request_payout(): void
    {
        $member = $this->member();
        MemberKyc::create(['user_id' => $member->id, 'status' => 'Pending']);

        $this->actingAs($member)
            ->post(route('payout.request.post'), $this->validPayload())
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseCount('payout_requests', 0);
        $this->assertSame(2000.0, (float) $member->fresh()->earning_wallet);
    }

    public function test_eligible_member_can_submit_payout_and_amount_is_reserved(): void
    {
        $member = $this->member();
        $this->approvedKyc($member);

        $this->actingAs($member)
            ->post(route('payout.request.post'), $this->validPayload(['amount' => 750]))
            ->assertRedirect(route('payout.list'))
            ->assertSessionHas('success');

        $payout = PayoutRequest::firstOrFail();

        $this->assertSame('Pending', $payout->status);
        $this->assertSame('Bank Transfer', $payout->mode);
        $this->assertSame('Test Bank', $payout->bank_name);
        $this->assertNotNull($payout->wallet_transaction_id);
        $this->assertSame(1250.0, (float) $member->fresh()->earning_wallet);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $member->id,
            'type' => 'Debit',
            'amount' => 750,
            'opening_balance' => 2000,
            'closing_balance' => 1250,
            'reference_no' => $payout->request_no,
        ]);
    }

    public function test_member_cannot_request_more_than_available_wallet(): void
    {
        $member = $this->member();
        $this->approvedKyc($member);

        $this->actingAs($member)
            ->post(route('payout.request.post'), $this->validPayload(['amount' => 2500]))
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseCount('payout_requests', 0);
        $this->assertDatabaseCount('earning_wallet_transactions', 0);
        $this->assertSame(2000.0, (float) $member->fresh()->earning_wallet);
    }

    public function test_admin_can_approve_pending_payout(): void
    {
        [$member, $payout] = $this->submittedPayout();
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.payouts.update', $payout), [
                'status' => 'Approved',
                'payment_transaction_id' => 'NEFT-TEST-1001',
                'admin_remark' => 'Paid to registered account.',
            ])
            ->assertSessionHas('success');

        $payout->refresh();
        $this->assertSame('Approved', $payout->status);
        $this->assertSame('NEFT-TEST-1001', $payout->payment_transaction_id);
        $this->assertSame($admin->id, $payout->processed_by);
        $this->assertNotNull($payout->processed_at);
        $this->assertSame(1250.0, (float) $member->fresh()->earning_wallet);
        $this->assertDatabaseCount('earning_wallet_transactions', 1);

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.payouts.update', $payout), [
                'status' => 'Rejected',
                'admin_remark' => 'Second decision should fail.',
            ])
            ->assertSessionHasErrors('status');

        $this->assertSame(1250.0, (float) $member->fresh()->earning_wallet);
    }

    public function test_admin_rejection_refunds_wallet_exactly_once(): void
    {
        [$member, $payout] = $this->submittedPayout();
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.payouts.update', $payout), [
                'status' => 'Rejected',
                'admin_remark' => 'Bank details need correction.',
            ])
            ->assertSessionHas('success');

        $payout->refresh();
        $this->assertSame('Rejected', $payout->status);
        $this->assertNotNull($payout->refund_transaction_id);
        $this->assertNotNull($payout->refunded_at);
        $this->assertSame(2000.0, (float) $member->fresh()->earning_wallet);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $member->id,
            'type' => 'Credit',
            'amount' => 750,
            'opening_balance' => 1250,
            'closing_balance' => 2000,
            'reference_no' => 'REFUND-'.$payout->request_no,
        ]);

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.payouts.update', $payout), [
                'status' => 'Rejected',
                'admin_remark' => 'Duplicate rejection.',
            ])
            ->assertSessionHasErrors('status');

        $this->assertSame(2000.0, (float) $member->fresh()->earning_wallet);
        $this->assertDatabaseCount('earning_wallet_transactions', 2);
    }

    public function test_user_and_admin_pages_show_live_payout_data(): void
    {
        [$member, $payout] = $this->submittedPayout();

        $this->actingAs($member)
            ->get(route('payout.request'))
            ->assertOk()
            ->assertSee($payout->request_no)
            ->assertSee('₹1,250.00');

        $this->actingAs($member)
            ->get(route('payout.list'))
            ->assertOk()
            ->assertSee($payout->request_no)
            ->assertSee('Pending');

        $this->actingAs($this->admin(), 'admin')
            ->get(route('admin.payouts.index'))
            ->assertOk()
            ->assertSee($payout->request_no)
            ->assertSee($member->member_id);
    }

    private function member(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'member_id' => 'ARM-PAYOUT-1',
            'status' => 'Active',
            'package_name' => 'Zenith Package',
            'earning_wallet' => 2000,
        ], $overrides));
    }

    private function approvedKyc(User $member): MemberKyc
    {
        return MemberKyc::create([
            'user_id' => $member->id,
            'account_holder_name' => $member->name,
            'bank_name' => 'Test Bank',
            'account_number' => '1234567890',
            'ifsc_code' => 'TEST0001234',
            'status' => 'Approved',
            'approved_at' => now(),
        ]);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'amount' => 750,
            'mode' => 'Bank Transfer',
            'member_remark' => 'Please process.',
            'details_confirmed' => '1',
        ], $overrides);
    }

    private function submittedPayout(): array
    {
        $member = $this->member();
        $this->approvedKyc($member);

        $this->actingAs($member)
            ->post(route('payout.request.post'), $this->validPayload())
            ->assertRedirect(route('payout.list'));

        return [$member, PayoutRequest::firstOrFail()];
    }

    private function admin(): Admin
    {
        return Admin::create([
            'name' => 'Payout Admin',
            'email' => fake()->unique()->safeEmail(),
            'mobile' => fake()->unique()->numerify('9#########'),
            'password' => 'password',
            'status' => 'Active',
        ]);
    }
}
