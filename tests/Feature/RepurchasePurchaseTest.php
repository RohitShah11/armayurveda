<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepurchasePurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_address_is_required_before_a_repurchase(): void
    {
        [$member, $product] = $this->memberAndProduct();

        $this->actingAs($member)
            ->from(route('catalog.show', $product))
            ->post(route('catalog.purchase', $product), ['quantity' => 1])
            ->assertRedirect(route('catalog.show', $product))
            ->assertSessionHasErrors(['delivery_address']);

        $this->assertDatabaseCount('product_orders', 0);
        $this->assertEquals(1000, $member->fresh()->main_wallet);
    }

    public function test_repurchase_saves_the_delivery_address_on_the_order(): void
    {
        [$member, $product] = $this->memberAndProduct();

        $this->actingAs($member)->post(route('catalog.purchase', $product), [
            'quantity' => 2,
            'delivery_address' => '12 Ayurveda Road, Near Central Park',
        ])->assertRedirect(route('catalog.orders'));

        $this->assertDatabaseHas('product_orders', [
            'user_id' => $member->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_amount' => 500,
            'delivery_address' => '12 Ayurveda Road, Near Central Park',
        ]);
        $this->assertEquals(500, $member->fresh()->main_wallet);
    }

    private function memberAndProduct(): array
    {
        $member = User::factory()->create(['main_wallet' => 1000]);
        $category = Category::create(['name' => 'Wellness', 'slug' => 'wellness', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nervogen-D Capsule',
            'slug' => 'nervogen-d-capsule',
            'mrp' => 300,
            'retail_price' => 250,
            'is_active' => true,
        ]);

        return [$member, $product];
    }
}
