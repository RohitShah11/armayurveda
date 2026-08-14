<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigitalIdCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_an_employee_id_card(): void
    {
        $this->get(route('profile.id-card'))->assertRedirect(route('login'));
    }

    public function test_employee_can_view_their_own_generated_id_card(): void
    {
        $employee = User::factory()->create([
            'name' => 'Arup Chowdhury',
            'member_id' => 'ARM1001',
            'sponsor_id' => 'ARM1004',
            'package_name' => 'Zenith Package',
            'status' => 'Active',
        ]);

        $this->actingAs($employee)
            ->get(route('profile.id-card'))
            ->assertOk()
            ->assertSee('DIGITAL ID CARD')
            ->assertSee('Arup Chowdhury')
            ->assertSee('ARM1001')
            ->assertSee('ARM1004')
            ->assertSee('Zenith Package')
            ->assertSee('Download ID Card');
    }
}
