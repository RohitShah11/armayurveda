<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_view_their_package_invoice(): void
    {
        $member = User::factory()->create(['member_id' => 'ARM-PKG-1']);
        $package = Package::create(['name' => 'Zenith Package', 'slug' => 'zenith-test', 'category' => 'Zenith', 'price' => 10500]);
        $purchase = PackagePurchase::create(['user_id' => $member->id, 'package_id' => $package->id, 'package_name' => $package->name, 'package_price' => 10500, 'status' => 'Completed', 'purchase_date' => now()]);

        $this->actingAs($member)->get(route('package.purchase.invoice', $purchase))
            ->assertOk()
            ->assertSee('PACKAGE INVOICE')
            ->assertSee('ARM-PKG-1')
            ->assertSee('Zenith Package')
            ->assertSee('Red Aloe Vera Juice')
            ->assertSee('Premium Backpack')
            ->assertSee('Dinner Set')
            ->assertSee('₹5,500.00')
            ->assertSee('Print / Save PDF');
    }

    public function test_member_cannot_view_another_members_package_invoice(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $package = Package::create(['name' => 'Zenith Package', 'slug' => 'zenith-private', 'category' => 'Zenith', 'price' => 10500]);
        $purchase = PackagePurchase::create(['user_id' => $owner->id, 'package_id' => $package->id, 'package_name' => $package->name, 'package_price' => 10500, 'status' => 'Completed', 'purchase_date' => now()]);

        $this->actingAs($other)->get(route('package.purchase.invoice', $purchase))->assertForbidden();
    }
}
