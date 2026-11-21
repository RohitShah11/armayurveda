<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_handles_legacy_member_without_joining_date(): void
    {
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['created_at' => null]);

        $this->actingAs($user->fresh())
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Joining Date')
            ->assertSee('<span>-</span>', false);
    }
}
