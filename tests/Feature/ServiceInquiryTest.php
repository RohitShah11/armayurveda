<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\ServiceInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceInquiryTest extends TestCase
{
    use RefreshDatabase;

    private function loanData(): array
    {
        return ['full_name' => 'Test Member', 'mobile' => '9242068805', 'email' => 'member@example.com', 'loan_type' => 'Business Loan', 'amount' => '250000.50', 'purpose' => 'Business Expansion', 'city' => 'Kolkata', 'remarks' => 'Private loan details'];
    }

    private function hotelData(): array
    {
        return ['full_name' => 'Test Guest', 'mobile' => '9242068805', 'check_in' => now()->addDay()->toDateString(), 'check_out' => now()->addDays(3)->toDateString(), 'guests' => 3, 'rooms' => 2, 'special_request' => 'Early check-in if available'];
    }

    public function test_guests_cannot_view_or_submit_either_form(): void
    {
        foreach (['loan-requirement', 'hotel-booking'] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
            $this->post(route($route.'.store'), [])->assertRedirect(route('login'));
        }
        $this->assertDatabaseCount('service_inquiries', 0);
    }

    public function test_member_can_open_both_forms(): void
    {
        $user = User::factory()->create(['member_id' => 'ARM1004']);
        $this->actingAs($user)->get(route('loan-requirement'))->assertOk()->assertSee('Loan Requirement Form')->assertSee('ARM1004');
        $this->get(route('hotel-booking'))->assertOk()->assertSee('Booking Inquiry Form')->assertSee('2,000');
    }

    public function test_loan_is_saved_for_authenticated_member_and_cannot_spoof_status_or_owner(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $this->actingAs($user)->post(route('loan-requirement.store'), $this->loanData() + ['user_id' => $other->id, 'status' => 'Closed', 'type' => 'hotel'])
            ->assertRedirect(route('loan-requirement'))->assertSessionHasNoErrors()->assertSessionHas('success');
        $inquiry = ServiceInquiry::sole();
        $this->assertSame($user->id, $inquiry->user_id);
        $this->assertSame('Pending', $inquiry->status);
        $this->assertSame('loan', $inquiry->type);
        $this->assertSame('250000.50', $inquiry->details['amount']);
        $this->get(route('loan-requirement'))->assertSee($inquiry->reference())->assertSee('Private loan details');
        $this->actingAs($other)->get(route('loan-requirement'))->assertDontSee($inquiry->reference())->assertDontSee('Private loan details');
    }

    public function test_hotel_saves_dates_and_server_owned_room_rate(): void
    {
        $this->actingAs(User::factory()->create())->post(route('hotel-booking.store'), $this->hotelData() + ['room_rate' => 1])->assertSessionHasNoErrors()->assertRedirect(route('hotel-booking'));
        $inquiry = ServiceInquiry::sole();
        $this->assertSame(2000, $inquiry->details['room_rate']);
        $this->assertSame('hotel', $inquiry->type);
        $this->get(route('hotel-booking'))->assertOk()->assertSee($inquiry->reference())->assertSee('Early check-in if available');
    }

    public function test_hotel_rejects_past_or_invalid_dates_and_counts(): void
    {
        $this->actingAs(User::factory()->create());
        $this->post(route('hotel-booking.store'), array_replace($this->hotelData(), ['check_in' => now()->subDay()->toDateString(), 'guests' => 0, 'rooms' => 0]))->assertSessionHasErrors(['check_in', 'guests', 'rooms']);
        $this->post(route('hotel-booking.store'), array_replace($this->hotelData(), ['check_out' => now()->addDay()->toDateString()]))->assertSessionHasErrors('check_out');
        $this->assertDatabaseCount('service_inquiries', 0);
    }

    public function test_loan_rejects_invalid_fields_and_keeps_input(): void
    {
        $this->actingAs(User::factory()->create())->from(route('loan-requirement'))->post(route('loan-requirement.store'), array_replace($this->loanData(), ['loan_type' => 'invalid', 'amount' => -1, 'mobile' => 'abc', 'city' => '', 'email' => 'bad']))->assertRedirect(route('loan-requirement'))->assertSessionHasErrors(['loan_type', 'amount', 'mobile', 'city', 'email'])->assertSessionHasInput('full_name', 'Test Member');
        $this->assertDatabaseCount('service_inquiries', 0);
    }

    public function test_admin_can_review_requests_and_member_sees_reply(): void
    {
        $user = User::factory()->create(['member_id' => 'ARM1004']);
        $this->actingAs($user)->post(route('hotel-booking.store'), $this->hotelData());
        $inquiry = ServiceInquiry::sole();
        $admin = Admin::create(['name' => 'Admin', 'email' => 'reviewer@example.com', 'password' => 'password', 'status' => 'Active']);
        $this->actingAs($admin, 'admin')->get(route('admin.service-inquiries.index'))->assertOk()->assertSee($inquiry->reference());
        $this->get(route('admin.service-inquiries.show', $inquiry))->assertOk()->assertSee('ARM1004')->assertSee('Early check-in');
        $this->patch(route('admin.service-inquiries.update', $inquiry), ['status' => 'Closed'])->assertSessionHasErrors('status');
        $this->patch(route('admin.service-inquiries.update', $inquiry), ['status' => 'Confirmed', 'admin_note' => 'Your room is confirmed.'])->assertSessionHasNoErrors();
        $this->assertSame('Confirmed', $inquiry->fresh()->status);
        $this->assertSame($admin->id, $inquiry->fresh()->reviewed_by);
        $this->assertNotNull($inquiry->fresh()->reviewed_at);
        $this->actingAs($user)->get(route('hotel-booking'))->assertOk()->assertSee('Your room is confirmed.');
    }

    public function test_members_cannot_access_admin_requests(): void
    {
        $this->actingAs(User::factory()->create())->post(route('loan-requirement.store'), $this->loanData());
        $inquiry = ServiceInquiry::sole();
        $this->get(route('admin.service-inquiries.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.service-inquiries.show', $inquiry))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.service-inquiries.update', $inquiry), ['status' => 'Closed'])->assertRedirect(route('admin.login'));
        $this->assertSame('Pending', $inquiry->fresh()->status);
    }
}
