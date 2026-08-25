<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_level_team_displays_live_sponsor_hierarchy_and_package_statuses(): void
    {
        $owner = User::factory()->create([
            'member_id' => 'ARM7001',
            'package_name' => 'Zenith Package',
        ]);
        $direct = User::factory()->create([
            'name' => 'Direct Zenith Member',
            'member_id' => 'ARM7002',
            'sponsor_id' => $owner->member_id,
            'package_name' => 'Zenith Package',
        ]);
        User::factory()->create([
            'name' => 'Second Level Inactive Member',
            'member_id' => 'ARM7003',
            'sponsor_id' => $direct->member_id,
            'package_name' => null,
        ]);
        User::factory()->create([
            'name' => 'Unrelated Member',
            'member_id' => 'ARM7999',
            'package_name' => 'Zenith Package',
        ]);

        $response = $this->actingAs($owner)->get(route('team.level'));

        $response
            ->assertOk()
            ->assertSee('Direct Zenith Member')
            ->assertSee('Second Level Inactive Member')
            ->assertDontSee('Unrelated Member')
            ->assertViewHas('totals', fn (array $totals) => $totals === [
                'members' => 2,
                'zenith' => 1,
                'inactive' => 1,
                'active' => 1,
            ])
            ->assertViewHas('levelSummary', fn ($summary) => $summary[1]['total'] === 1
                && $summary[1]['zenith'] === 1
                && $summary[2]['total'] === 1
                && $summary[2]['inactive'] === 1);
    }

    public function test_level_team_filters_members_by_level_package_and_search(): void
    {
        $owner = User::factory()->create(['member_id' => 'ARM8001']);
        $direct = User::factory()->create([
            'name' => 'Filter Direct',
            'member_id' => 'ARM8002',
            'sponsor_id' => $owner->member_id,
            'package_name' => 'Zenith Package',
        ]);
        User::factory()->create([
            'name' => 'Filter Target',
            'member_id' => 'ARM8003',
            'sponsor_id' => $direct->member_id,
            'package_name' => null,
        ]);

        $this->actingAs($owner)
            ->get(route('team.level', ['level' => 2, 'package' => 'Inactive', 'search' => 'ARM8003']))
            ->assertOk()
            ->assertSee('Filter Target')
            ->assertDontSee('Filter Direct')
            ->assertViewHas('members', fn ($members) => $members->total() === 1);
    }
}
