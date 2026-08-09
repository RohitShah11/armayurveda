<?php

namespace Tests\Feature;

use App\Http\Controllers\MemberController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class DirectMemberStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_direct_member_cards_use_live_counts_for_the_authenticated_member(): void
    {
        $owner = User::factory()->create([
            'member_id' => 'ARM5000',
        ]);

        $activeMember = User::factory()->create([
            'member_id' => 'ARM5001',
            'sponsor_id' => $owner->member_id,
            'status' => 'Active',
            'package_name' => 'Zenith Package',
        ]);

        User::factory()->create([
            'member_id' => 'ARM5002',
            'sponsor_id' => $owner->member_id,
            'status' => 'Active',
            'package_name' => null,
        ]);

        User::factory()->create([
            'member_id' => 'ARM5003',
            'sponsor_id' => $owner->member_id,
            'status' => 'Inactive',
            'package_name' => 'Basic Package',
        ]);

        User::factory()->create([
            'member_id' => 'ARM5004',
            'sponsor_id' => $activeMember->member_id,
            'status' => 'Active',
            'package_name' => 'Zenith Package',
        ]);

        $this->actingAs($owner);

        $view = app(MemberController::class)->memberList(
            Request::create('/team/direct', 'GET')
        );

        $this->assertSame([
            'total_direct' => 3,
            'active_direct' => 2,
            'pending_package' => 1,
            'active_members' => 1,
        ], $view->getData()['stats']);

        $view->with('members', User::query()->whereKey(-1)->paginate(10));
        $view->with('errors', new ViewErrorBag);
        $html = $view->render();

        $this->assertMatchesRegularExpression('/<p>Total Direct<\/p>\s*<h3>3<\/h3>/', $html);
        $this->assertMatchesRegularExpression('/<p>Active Direct<\/p>\s*<h3>2<\/h3>/', $html);
        $this->assertMatchesRegularExpression('/<p>Pending Package<\/p>\s*<h3>1<\/h3>/', $html);
        $this->assertMatchesRegularExpression('/<p>Active Members<\/p>\s*<h3>1<\/h3>/', $html);
    }
}
