<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackagePurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_basic_package_from_wallet(): void
    {
        $basic = Package::create([
            'name' => 'Basic Package',
            'slug' => 'basic-package',
            'price' => 1999,
            'category' => 'Basic',
            'description' => 'Starter package',
            'image' => null,
        ]);

        $user = User::factory()->create([
            'main_wallet' => 5000,
            'package_name' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('package.purchase.store'), [
            'package_id' => $basic->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('Basic Package', $user->package_name);
        $this->assertSame(3001.00, (float) $user->main_wallet);
        $this->assertDatabaseHas('main_wallet_transactions', [
            'user_id' => $user->id,
            'transaction_type' => 'Debit',
            'particular' => 'Package purchase',
        ]);
    }

    public function test_package_purchase_creates_purchase_record_and_distributes_level_commissions(): void
    {
        $basic = Package::create([
            'name' => 'Basic Package',
            'slug' => 'basic-package',
            'price' => 1999,
            'category' => 'Basic',
            'description' => 'Starter package',
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
            'main_wallet' => 5000,
            'package_name' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('package.purchase.store'), [
            'package_id' => $basic->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $level1Sponsor->refresh();
        $level2Sponsor->refresh();

        $this->assertSame(3001.00, (float) $user->main_wallet);
        $this->assertSame(200.00, (float) $level1Sponsor->main_wallet);
        $this->assertSame(100.00, (float) $level2Sponsor->main_wallet);
        $this->assertDatabaseHas('package_purchases', [
            'user_id' => $user->id,
            'package_id' => $basic->id,
            'package_name' => 'Basic Package',
            'package_price' => '1999.00',
        ]);
        $this->assertDatabaseHas('main_wallet_transactions', [
            'user_id' => $level1Sponsor->id,
            'transaction_type' => 'Credit',
            'particular' => 'Level commission',
            'amount' => '200.00',
        ]);
        $this->assertDatabaseHas('main_wallet_transactions', [
            'user_id' => $level2Sponsor->id,
            'transaction_type' => 'Credit',
            'particular' => 'Level commission',
            'amount' => '100.00',
        ]);
    }
}
