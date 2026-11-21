<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\GuestProductOrder;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuestProductOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_product_page_links_to_checkout_instead_of_login(): void
    {
        $product = $this->product();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Order Now')
            ->assertSee(route('guest-orders.create', $product), false)
            ->assertDontSee('Login to Purchase');
    }

    public function test_guest_can_place_cash_order_and_server_owns_product_price(): void
    {
        Storage::fake('local');
        $product = $this->product();

        $response = $this->post(route('guest-orders.store', $product), $this->orderData() + [
            'payment_method' => 'Cash',
            'quantity' => 2,
            'unit_price' => 1,
            'utr_number' => 'SHOULD-NOT-SAVE',
        ]);

        $order = GuestProductOrder::sole();
        $response->assertRedirect(route('guest-orders.success', ['guestProductOrder' => $order->public_token]));
        $this->assertSame('Cash', $order->payment_method);
        $this->assertSame('Pending', $order->payment_status);
        $this->assertSame('500.00', $order->total_amount);
        $this->assertNull($order->utr_number);
        $this->assertNull($order->payment_proof);
    }

    public function test_online_payment_requires_and_privately_stores_proof_and_utr(): void
    {
        Storage::fake('local');
        $product = $this->product();

        $this->post(route('guest-orders.store', $product), $this->orderData() + ['payment_method' => 'Online'])
            ->assertSessionHasErrors(['utr_number', 'payment_proof']);

        $this->post(route('guest-orders.store', $product), $this->orderData() + [
            'payment_method' => 'Online',
            'utr_number' => 'UTR123456789',
            'payment_proof' => UploadedFile::fake()->image('payment.jpg'),
        ])->assertSessionHasNoErrors();

        $order = GuestProductOrder::sole();
        $this->assertSame('Submitted', $order->payment_status);
        $this->assertSame('UTR123456789', $order->utr_number);
        Storage::disk('local')->assertExists($order->payment_proof);
    }

    public function test_admin_can_review_and_update_guest_order(): void
    {
        $product = $this->product();
        $order = GuestProductOrder::create($this->storedOrderData($product));
        $admin = Admin::create(['name' => 'Admin', 'email' => 'guest-orders@example.com', 'password' => 'password', 'status' => 'Active']);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.guest-orders.index'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('Test Customer');

        $this->get(route('admin.guest-orders.show', $order))->assertOk()->assertSee('12 Ayurveda Road');
        $this->patch(route('admin.guest-orders.update', $order), [
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'admin_note' => 'Confirmed by phone.',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('guest_product_orders', ['id' => $order->id, 'status' => 'Confirmed', 'payment_status' => 'Paid']);
    }

    public function test_guest_cannot_access_admin_guest_orders(): void
    {
        $product = $this->product();
        $order = GuestProductOrder::create($this->storedOrderData($product));

        $this->get(route('admin.guest-orders.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.guest-orders.show', $order))->assertRedirect(route('admin.login'));
        $this->get(route('admin.guest-orders.proof', $order))->assertRedirect(route('admin.login'));
    }

    private function product(): Product
    {
        $category = Category::create(['name' => 'Wellness', 'slug' => 'wellness-'.uniqid(), 'is_active' => true]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Herbal Capsules',
            'slug' => 'herbal-capsules-'.uniqid(),
            'mrp' => 300,
            'retail_price' => 250,
            'is_active' => true,
        ]);
    }

    private function orderData(): array
    {
        return [
            'customer_name' => 'Test Customer',
            'mobile' => '9242068805',
            'email' => 'customer@example.com',
            'shipping_address' => '12 Ayurveda Road',
            'city' => 'Kolkata',
            'state' => 'West Bengal',
            'pincode' => '700001',
            'quantity' => 1,
        ];
    }

    private function storedOrderData(Product $product): array
    {
        return $this->orderData() + [
            'public_token' => fake()->uuid(),
            'order_number' => 'GPO-TEST-'.uniqid(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'unit_price' => 250,
            'total_amount' => 250,
            'payment_method' => 'Cash on Delivery',
            'payment_status' => 'Pending',
            'status' => 'Pending',
            'ordered_at' => now(),
        ];
    }
}
