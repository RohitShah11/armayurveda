<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EarningWalletTransaction;
use App\Models\PayoutRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PayoutController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'status' => ['nullable', Rule::in(['Pending', 'Approved', 'Rejected'])],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $baseQuery = PayoutRequest::query();

        $payouts = PayoutRequest::query()
            ->with(['user.kyc', 'processedBy'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('request_no', 'like', "%{$search}%")
                        ->orWhere('payment_transaction_id', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('member_id', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.payouts.index', [
            'payouts' => $payouts,
            'totalRequests' => (clone $baseQuery)->count(),
            'pendingRequests' => (clone $baseQuery)->where('status', 'Pending')->count(),
            'pendingAmount' => (float) (clone $baseQuery)->where('status', 'Pending')->sum('amount'),
            'paidAmount' => (float) (clone $baseQuery)->where('status', 'Approved')->sum('net_amount'),
        ]);
    }

    public function update(Request $request, PayoutRequest $payoutRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Approved', 'Rejected'])],
            'payment_transaction_id' => ['nullable', 'required_if:status,Approved', 'string', 'max:100'],
            'admin_remark' => ['nullable', 'required_if:status,Rejected', 'string', 'max:500'],
        ], [
            'payment_transaction_id.required_if' => 'The payment transaction ID is required when approving a payout.',
            'admin_remark.required_if' => 'An admin remark is required when rejecting a payout.',
        ]);

        DB::transaction(function () use ($payoutRequest, $validated) {
            $payout = PayoutRequest::whereKey($payoutRequest->id)->lockForUpdate()->firstOrFail();

            if ($payout->status !== 'Pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending payout requests can be processed.',
                ]);
            }

            if ($validated['status'] === 'Rejected') {
                $this->refundPayout($payout);
            }

            $payout->update([
                'status' => $validated['status'],
                'payment_transaction_id' => $validated['status'] === 'Approved'
                    ? $validated['payment_transaction_id']
                    : null,
                'admin_remark' => $validated['admin_remark'] ?? null,
                'processed_by' => Auth::guard('admin')->id(),
                'processed_at' => now(),
            ]);
        });

        return back()->with('success', "Payout request {$payoutRequest->request_no} {$validated['status']} successfully.");
    }

    private function refundPayout(PayoutRequest $payout): void
    {
        if ($payout->refunded_at || $payout->refund_transaction_id) {
            throw ValidationException::withMessages([
                'status' => 'This payout amount has already been returned to the member.',
            ]);
        }

        $user = User::whereKey($payout->user_id)->lockForUpdate()->firstOrFail();
        $amount = round((float) $payout->amount, 2);
        $openingBalance = round((float) ($user->earning_wallet ?? 0), 2);
        $closingBalance = round($openingBalance + $amount, 2);

        $user->update(['earning_wallet' => $closingBalance]);

        $refundTransaction = EarningWalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'Credit',
            'amount' => $amount,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'description' => 'Refund for rejected payout request',
            'reference_no' => 'REFUND-'.$payout->request_no,
            'transaction_date' => now(),
        ]);

        $payout->update([
            'refund_transaction_id' => $refundTransaction->id,
            'refunded_at' => now(),
        ]);
    }
}
