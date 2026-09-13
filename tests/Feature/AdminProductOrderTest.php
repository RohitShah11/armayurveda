<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\ProductOrder;
use App\Models\User;
use App\Services\RepurchaseCommissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminProductOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_repurchase_order_details(): void
    {
        [$admin, $order] = $this->adminAndOrder('Pending');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.product-orders.show', $order))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('Test Member')
            ->assertSee('Nervogen-D Capsule')
            ->assertSee('12 Ayurveda Road, Ahmedabad')
            ->assertSee('Confirmed')
            ->assertSee('Cancelled');
    }

    public function test_order_can_only_move_to_an_available_forward_status(): void
    {
        [$admin, $order] = $this->adminAndOrder('Processing');

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.product-orders.update', $order), ['status' => 'Confirmed'])
            ->assertSessionHasErrors('status');

        $this->assertSame('Processing', $order->fresh()->status);

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.product-orders.update', $order), ['status' => 'Shipped'])
            ->assertSessionHasNoErrors();

        $this->assertSame('Shipped', $order->fresh()->status);
    }

    public function test_delivered_and_cancelled_orders_cannot_change_status(): void
    {
        foreach (['Delivered', 'Cancelled'] as $status) {
            [$admin, $order] = $this->adminAndOrder($status);

            $this->actingAs($admin, 'admin')
                ->patch(route('admin.product-orders.update', $order), ['status' => 'Pending'])
                ->assertSessionHasErrors('status');

            $this->assertSame($status, $order->fresh()->status);
        }
    }

    public function test_marking_an_order_delivered_distributes_level_commission_once(): void
    {
        $admin = Admin::create(['name' => 'Admin', 'email' => 'commission-admin@example.com', 'mobile' => '9000000099', 'password' => 'password', 'status' => 'Active']);
        $sponsors = [];
        $parentMemberId = null;

        for ($level = 10; $level >= 1; $level--) {
            $sponsors[$level] = User::factory()->create([
                'member_id' => 'ARM-L'.$level,
                'sponsor_id' => $parentMemberId,
                'earning_wallet' => 0,
            ]);
            $parentMemberId = $sponsors[$level]->member_id;
        }

        $buyer = User::factory()->create(['member_id' => 'ARM-BUYER', 'sponsor_id' => $sponsors[1]->member_id]);
        $order = ProductOrder::create([
            'order_number' => 'RPO-COMMISSION-001',
            'user_id' => $buyer->id,
            'product_name' => 'Nervogen-D Capsule',
            'unit_price' => 1000,
            'quantity' => 1,
            'total_amount' => 1000,
            'status' => 'Pending',
            'payment_status' => 'Paid',
            'delivery_address' => 'Ahmedabad',
            'ordered_at' => now(),
        ]);

        $this->actingAs($admin, 'admin')
            ->patch(route('admin.product-orders.update', $order), ['status' => 'Delivered'])
            ->assertSessionHasNoErrors();

        $expected = [1 => 50, 2 => 20, 3 => 10, 4 => 4, 5 => 4, 6 => 4, 7 => 2, 8 => 2, 9 => 2, 10 => 2];

        foreach ($expected as $level => $amount) {
            $this->assertEquals($amount, (float) $sponsors[$level]->fresh()->earning_wallet);
            $this->assertDatabaseHas('earning_wallet_transactions', [
                'user_id' => $sponsors[$level]->id,
                'source_user_id' => $buyer->id,
                'product_order_id' => $order->id,
                'level' => $level,
                'amount' => $amount,
            ]);
        }

        DB::transaction(fn () => app(RepurchaseCommissionService::class)->distribute($order->fresh()));

        $this->assertDatabaseCount('earning_wallet_transactions', 10);
        $this->assertEquals(50, (float) $sponsors[1]->fresh()->earning_wallet);
    }

    private function adminAndOrder(string $status): array
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => uniqid('admin').'@example.com',
            'mobile' => (string) random_int(7000000000, 9999999999),
            'password' => 'password',
            'status' => 'Active',
        ]);
        $member = User::factory()->create(['name' => 'Test Member']);
        $order = ProductOrder::create([
            'order_number' => uniqid('RPO-'),
            'user_id' => $member->id,
            'product_name' => 'Nervogen-D Capsule',
            'unit_price' => 250,
            'quantity' => 2,
            'total_amount' => 500,
            'status' => $status,
            'payment_status' => $status === 'Cancelled' ? 'Refunded' : 'Paid',
            'delivery_address' => '12 Ayurveda Road, Ahmedabad',
            'ordered_at' => now(),
        ]);

        return [$admin, $order];
    }
}
