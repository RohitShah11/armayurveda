<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMemberLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_as_a_member_without_knowing_their_password(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'mobile' => '9000000000',
            'password' => 'password',
            'status' => 'Active',
        ]);
        $member = User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.members.login', $member))
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertAuthenticatedAs($member, 'web');
        $this->assertSame($admin->id, session('impersonated_by_admin_id'));
    }

    public function test_guest_cannot_use_the_admin_member_login_route(): void
    {
        $member = User::factory()->create();

        $this->post(route('admin.members.login', $member))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest('web');
    }
}
