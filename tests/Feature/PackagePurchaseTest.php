<?php

namespace Tests\Feature;

use App\Mail\PackagePurchased;
use App\Models\DirectTreeNode;
use App\Models\EarningWalletTransaction;
use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\SponsorPoolNode;
use App\Models\User;
use App\Models\ZenithPoolNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PackagePurchaseTest extends TestCase
{
    use RefreshDatabase;

    private User $rootUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rootUser = User::factory()->create([
            'name' => 'Admin Root User',
            'email' => 'root@armayurveda.test',
            'member_id' => 'ARM1000',
            'sponsor_id' => null,
            'main_wallet' => 0,
            'earning_wallet' => 0,
            'status' => 'Active',
        ]);
    }

    public function test_user_can_purchase_zenith_package_directly_from_wallet(): void
    {
        Mail::fake();
        $zenith = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
            'description' => 'Zenith package',
            'image' => null,
        ]);

        $user = User::factory()->create([
            'main_wallet' => 20000,
            'package_name' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('package.purchase.store'), [
            'package_id' => $zenith->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('Zenith Package', $user->package_name);
        $this->assertSame(9750.00, (float) $user->main_wallet);
        $this->assertDatabaseHas('main_wallet_transactions', [
            'user_id' => $user->id,
            'transaction_type' => 'Debit',
            'particular' => 'Package purchase',
        ]);

        $root = DirectTreeNode::whereNull('parent_id')->first();
        $this->assertSame($this->rootUser->id, $root->user_id);
        $this->assertDatabaseHas('direct_tree_nodes', [
            'user_id' => $user->id,
            'parent_id' => $root->id,
            'depth' => 1,
        ]);

        $zenithRoot = ZenithPoolNode::whereNull('parent_id')->first();
        $this->assertSame($this->rootUser->id, $zenithRoot->user_id);
        $this->assertDatabaseHas('zenith_pool_nodes', [
            'user_id' => $user->id,
            'parent_id' => $zenithRoot->id,
            'depth' => 1,
        ]);
        $this->assertDatabaseCount('admins', 0);

        Mail::assertSent(PackagePurchased::class, function (PackagePurchased $mail) use ($user) {
            return $mail->hasTo($user->email)
                && $mail->purchase->package_name === 'Zenith Package'
                && str_contains($mail->render(), 'View Your Invoice');
        });
    }

    public function test_package_purchase_page_uses_the_zenith_package_image(): void
    {
        Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
            'image' => null,
        ]);
        $user = User::factory()->create([
            'main_wallet' => 20000,
            'package_name' => null,
        ]);

        $this->actingAs($user)
            ->get(route('package.purchase'))
            ->assertOk()
            ->assertSee(asset('images/zenith-package.jpeg'), false)
            ->assertSee('alt="Zenith Package"', false);
    }

    public function test_package_purchase_creates_purchase_record_and_distributes_level_commissions(): void
    {
        $zenith = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
            'description' => 'Zenith package',
            'image' => null,
        ]);

        $level2Sponsor = User::factory()->create([
            'member_id' => 'ARM1001',
            'sponsor_id' => null,
            'main_wallet' => 0,
        ]);

        $level1Sponsor = User::factory()->create([
            'member_id' => 'ARM1002',
            'sponsor_id' => 'ARM1001',
            'main_wallet' => 0,
        ]);

        $user = User::factory()->create([
            'member_id' => 'ARM1003',
            'sponsor_id' => 'ARM1002',
            'main_wallet' => 20000,
            'package_name' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('package.purchase.store'), [
            'package_id' => $zenith->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $level1Sponsor->refresh();
        $level2Sponsor->refresh();

        $this->assertSame(9750.00, (float) $user->main_wallet);
        $this->assertSame(300.00, (float) $level1Sponsor->earning_wallet);
        $this->assertSame(150.00, (float) $level2Sponsor->earning_wallet);
        $this->assertDatabaseHas('package_purchases', [
            'user_id' => $user->id,
            'package_id' => $zenith->id,
            'package_name' => 'Zenith Package',
            'package_price' => '10500.00',
        ]);
        $packagePurchase = PackagePurchase::where('user_id', $user->id)->firstOrFail();
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $level1Sponsor->id,
            'source_user_id' => $user->id,
            'package_purchase_id' => $packagePurchase->id,
            'level' => 1,
            'type' => 'Credit',
            'description' => 'Level 1 commission for Zenith Package',
            'amount' => '300.00',
        ]);
        $this->assertDatabaseHas('earning_wallet_transactions', [
            'user_id' => $level2Sponsor->id,
            'source_user_id' => $user->id,
            'package_purchase_id' => $packagePurchase->id,
            'level' => 2,
            'type' => 'Credit',
            'description' => 'Level 2 commission for Zenith Package',
            'amount' => '150.00',
        ]);
        $this->assertNotNull(
            EarningWalletTransaction::where('user_id', $level1Sponsor->id)
                ->where('description', 'Level 1 commission for Zenith Package')
                ->firstOrFail()
                ->transaction_date
        );

        $sponsorRoot = SponsorPoolNode::whereNull('parent_id')->first();
        $this->assertSame($this->rootUser->id, $sponsorRoot->user_id);
    }

    public function test_package_purchase_places_member_under_sponsor_in_direct_tree(): void
    {
        $zenith = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
            'description' => 'Zenith package',
            'image' => null,
        ]);

        $sponsor = User::factory()->create([
            'member_id' => 'ARM2001',
            'sponsor_id' => null,
            'main_wallet' => 20000,
        ]);

        $user = User::factory()->create([
            'member_id' => 'ARM2002',
            'sponsor_id' => 'ARM2001',
            'main_wallet' => 20000,
        ]);

        $this->actingAs($sponsor)->post(route('package.purchase.store'), [
            'package_id' => $zenith->id,
        ])->assertRedirect();

        $this->actingAs($user)->post(route('package.purchase.store'), [
            'package_id' => $zenith->id,
        ])->assertRedirect();

        $sponsorNode = DirectTreeNode::where('user_id', $sponsor->id)->first();

        $this->assertDatabaseHas('direct_tree_nodes', [
            'user_id' => $user->id,
            'parent_id' => $sponsorNode->id,
            'depth' => $sponsorNode->depth + 1,
        ]);
    }

    public function test_user_cannot_purchase_a_package_more_than_once(): void
    {
        $zenith = Package::create([
            'name' => 'Zenith Package',
            'slug' => 'zenith-package',
            'price' => 10500,
            'category' => 'Zenith',
        ]);
        $user = User::factory()->create([
            'main_wallet' => 30000,
            'package_name' => null,
        ]);

        $this->actingAs($user)
            ->post(route('package.purchase.store'), ['package_id' => $zenith->id])
            ->assertSessionHas('success');

        $balanceAfterFirstPurchase = (float) $user->fresh()->main_wallet;

        $this->actingAs($user)
            ->post(route('package.purchase.store'), ['package_id' => $zenith->id])
            ->assertSessionHasErrors('package');

        $this->assertSame($balanceAfterFirstPurchase, (float) $user->fresh()->main_wallet);
        $this->assertDatabaseCount('package_purchases', 1);
        $this->assertDatabaseCount('main_wallet_transactions', 2);

        $this->actingAs($user)
            ->get(route('package.purchase'))
            ->assertOk()
            ->assertSee('Package Already Purchased')
            ->assertDontSee('Purchase Now');
    }

    public function test_basic_package_cannot_be_purchased(): void
    {
        $basic = Package::create([
            'name' => 'Basic Package',
            'slug' => 'basic-package',
            'price' => 1999,
            'category' => 'Basic',
        ]);

        $user = User::factory()->create([
            'main_wallet' => 5000,
            'package_name' => null,
        ]);

        $this->actingAs($user)
            ->post(route('package.purchase.store'), ['package_id' => $basic->id])
            ->assertSessionHasErrors('package');

        $this->assertSame(5000.00, (float) $user->fresh()->main_wallet);
        $this->assertDatabaseMissing('package_purchases', [
            'user_id' => $user->id,
            'package_id' => $basic->id,
        ]);
    }
}
