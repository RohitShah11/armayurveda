<?php

namespace Tests\Feature;

use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepurchaseInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_view_their_dynamic_repurchase_invoice(): void
    {
        $member = User::factory()->create(['member_id' => 'ARM0001']);
        $order = ProductOrder::create([
            'order_number' => 'RPO-TEST-001', 'user_id' => $member->id, 'product_name' => 'Ayurvedic Hair Oil',
            'unit_price' => 500, 'quantity' => 2, 'total_amount' => 1000,
            'status' => 'Pending', 'payment_status' => 'Paid', 'ordered_at' => now(),
        ]);

        $this->actingAs($member)->get(route('catalog.orders.invoice', $order))
            ->assertOk()
            ->assertSee('ARM/INV/'.now()->format('Y').'/'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT))
            ->assertSee('RPO-TEST-001')
            ->assertSee('Ayurvedic Hair Oil')
            ->assertSee('Print / Save PDF');
    }

    public function test_member_cannot_view_another_members_invoice(): void
    {
        $owner = User::factory()->create();
        $otherMember = User::factory()->create();
        $order = ProductOrder::create([
            'order_number' => 'RPO-PRIVATE-001', 'user_id' => $owner->id, 'product_name' => 'Private Order',
            'unit_price' => 250, 'quantity' => 1, 'total_amount' => 250,
            'status' => 'Pending', 'payment_status' => 'Paid', 'ordered_at' => now(),
        ]);

        $this->actingAs($otherMember)->get(route('catalog.orders.invoice', $order))->assertForbidden();
    }
}
