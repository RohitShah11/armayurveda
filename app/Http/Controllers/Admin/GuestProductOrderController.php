<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuestProductOrderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'status' => ['nullable', Rule::in(GuestProductOrder::STATUSES)],
            'payment_method' => ['nullable', Rule::in(GuestProductOrder::PAYMENT_METHODS)],
        ]);

        $orders = GuestProductOrder::with('product')
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('product_name', 'like', "%{$search}%")
                        ->orWhere('utr_number', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['payment_method'] ?? null, fn ($query, $method) => $query->where('payment_method', $method))
            ->latest('ordered_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.guest-orders.index', compact('orders'));
    }

    public function show(GuestProductOrder $guestProductOrder)
    {
        $guestProductOrder->load('product.category');

        return view('admin.guest-orders.show', ['order' => $guestProductOrder]);
    }

    public function update(Request $request, GuestProductOrder $guestProductOrder)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(GuestProductOrder::STATUSES)],
            'payment_status' => ['required', Rule::in(GuestProductOrder::PAYMENT_STATUSES)],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $guestProductOrder->update($data);

        return back()->with('success', 'Guest order updated successfully.');
    }

    public function proof(GuestProductOrder $guestProductOrder)
    {
        abort_unless($guestProductOrder->payment_proof && Storage::disk('local')->exists($guestProductOrder->payment_proof), 404);

        return Storage::disk('local')->response($guestProductOrder->payment_proof);
    }
}
