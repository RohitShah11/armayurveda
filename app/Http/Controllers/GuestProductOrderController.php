<?php

namespace App\Http\Controllers;

use App\Models\GuestProductOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GuestProductOrderController extends Controller
{
    public function create(Product $product)
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);

        return view('front.guest-checkout', [
            'product' => $product,
            'bank' => config('guest_checkout.bank'),
        ]);
    }

    public function store(Request $request, Product $product)
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:150'],
            'state' => ['required', 'string', 'max:150'],
            'pincode' => ['required', 'string', 'regex:/^[1-9][0-9]{5}$/'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'payment_method' => ['required', Rule::in(GuestProductOrder::PAYMENT_METHODS)],
            'utr_number' => ['nullable', 'required_if:payment_method,Online', 'string', 'max:100'],
            'payment_proof' => ['nullable', 'required_if:payment_method,Online', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'mobile.regex' => 'Enter a valid 10-digit Indian mobile number.',
            'pincode.regex' => 'Enter a valid 6-digit Indian PIN code.',
            'utr_number.required_if' => 'Enter the UTR or transaction reference for an online payment.',
            'payment_proof.required_if' => 'Upload the payment screenshot for an online payment.',
        ]);

        $proofPath = null;
        if ($data['payment_method'] === 'Online') {
            $proofPath = $request->file('payment_proof')->store('guest-order-proofs', 'local');
        }

        try {
            $quantity = (int) $data['quantity'];
            $order = GuestProductOrder::create([
                'public_token' => (string) Str::uuid(),
                'order_number' => 'GPO-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6)),
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->retail_price,
                'quantity' => $quantity,
                'total_amount' => round((float) $product->retail_price * $quantity, 2),
                'customer_name' => $data['customer_name'],
                'mobile' => $data['mobile'],
                'email' => $data['email'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'Online' ? 'Submitted' : 'Pending',
                'utr_number' => $data['payment_method'] === 'Online' ? $data['utr_number'] : null,
                'payment_proof' => $proofPath,
                'status' => 'Pending',
                'ordered_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            if ($proofPath) {
                Storage::disk('local')->delete($proofPath);
            }
            throw $exception;
        }

        return redirect()->route('guest-orders.success', ['guestProductOrder' => $order->public_token]);
    }

    public function success(GuestProductOrder $guestProductOrder)
    {
        return view('front.guest-order-success', ['order' => $guestProductOrder]);
    }
}
