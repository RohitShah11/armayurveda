<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSponsorTest extends TestCase
{
    use RefreshDatabase;

    public function test_sponsor_lookup_returns_the_member_name(): void
    {
        $sponsor = User::factory()->create([
            'member_id' => 'ARM4321',
            'name' => 'Valid Sponsor',
        ]);

        $this->getJson(route('register.sponsor', ['member_id' => strtolower($sponsor->member_id)]))
            ->assertOk()
            ->assertJson([
                'available' => true,
                'member_id' => $sponsor->member_id,
                'name' => $sponsor->name,
            ]);
    }

    public function test_sponsor_lookup_reports_an_unknown_member_id(): void
    {
        $this->getJson(route('register.sponsor', ['member_id' => 'ARM9999']))
            ->assertNotFound()
            ->assertJson([
                'available' => false,
                'message' => 'Sponsor is not available.',
            ]);
    }

    public function test_registration_rejects_an_unknown_sponsor_id(): void
    {
        $response = $this->from(route('register'))->post(route('register.post'), [
            'name' => 'New Member',
            'mobile' => '9876543210',
            'email' => 'new-member@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'sponsor_id' => 'ARM9999',
        ]);

        $response
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors([
                'sponsor_id' => 'Sponsor is not available.',
            ]);

        $this->assertDatabaseMissing('users', [
            'mobile' => '9876543210',
        ]);
    }
}
