<?php

namespace App\Http\Controllers;

use App\Models\EarningWalletTransaction;
use App\Models\MemberKyc;
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
    public function create(): View
    {
        $user = User::with('kyc')->findOrFail(Auth::id());
        $recentPayouts = $user->payoutRequests()->latest()->take(5)->get();

        return view('pages.payout', [
            'user' => $user,
            'kyc' => $user->kyc,
            'isPackageActive' => filled(trim((string) $user->package_name)),
            'isKycApproved' => $user->kyc?->status === 'Approved',
            'minimumAmount' => PayoutRequest::MINIMUM_AMOUNT,
            'pendingAmount' => (float) $user->payoutRequests()->where('status', 'Pending')->sum('amount'),
            'totalPaid' => (float) $user->payoutRequests()->where('status', 'Approved')->sum('net_amount'),
            'recentPayouts' => $recentPayouts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:'.PayoutRequest::MINIMUM_AMOUNT, 'max:999999999.99'],
            'mode' => ['required', Rule::in(['Bank Transfer', 'UPI'])],
            'upi_id' => [
                'nullable',
                'required_if:mode,UPI',
                'string',
                'max:100',
                'regex:/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+$/',
            ],
            'member_remark' => ['nullable', 'string', 'max:500'],
            'details_confirmed' => ['accepted'],
        ], [
            'amount.min' => 'The minimum payout amount is INR '.PayoutRequest::MINIMUM_AMOUNT.'.',
            'upi_id.required_if' => 'Please enter the UPI ID that should receive this payout.',
            'upi_id.regex' => 'Please enter a valid UPI ID.',
            'details_confirmed.accepted' => 'Please confirm that your payout details are correct.',
        ]);

        $payout = DB::transaction(function () use ($validated) {
            $user = User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();
            $kyc = MemberKyc::where('user_id', $user->id)->lockForUpdate()->first();

            if (blank(trim((string) $user->package_name))) {
                throw ValidationException::withMessages([
                    'amount' => 'You must have an active package before requesting a payout.',
                ]);
            }

            if ($kyc?->status !== 'Approved') {
                throw ValidationException::withMessages([
                    'amount' => 'Your KYC must be approved before requesting a payout.',
                ]);
            }

            if ($validated['mode'] === 'Bank Transfer' && collect([
                $kyc->account_holder_name,
                $kyc->bank_name,
                $kyc->account_number,
                $kyc->ifsc_code,
            ])->contains(fn ($value) => blank($value))) {
                throw ValidationException::withMessages([
                    'mode' => 'Complete your bank details in KYC before selecting Bank Transfer.',
                ]);
            }

            $amount = round((float) $validated['amount'], 2);
            $openingBalance = round((float) ($user->earning_wallet ?? 0), 2);

            if ($openingBalance < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'The requested amount is greater than your available earning wallet balance.',
                ]);
            }

            $payout = PayoutRequest::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'charge' => 0,
                'net_amount' => $amount,
                'mode' => $validated['mode'],
                'upi_id' => $validated['mode'] === 'UPI' ? $validated['upi_id'] : null,
                'account_holder_name' => $kyc->account_holder_name,
                'bank_name' => $kyc->bank_name,
                'account_number' => $kyc->account_number,
                'ifsc_code' => $kyc->ifsc_code,
                'member_remark' => $validated['member_remark'] ?? null,
                'status' => 'Pending',
            ]);

            $requestNumber = 'PAY-'.now()->format('Ymd').'-'.str_pad((string) $payout->id, 6, '0', STR_PAD_LEFT);
            $closingBalance = round($openingBalance - $amount, 2);

            $user->update(['earning_wallet' => $closingBalance]);

            $walletTransaction = EarningWalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'Debit',
                'amount' => $amount,
                'opening_balance' => $openingBalance,
                'closing_balance' => $closingBalance,
                'description' => 'Amount reserved for payout request',
                'reference_no' => $requestNumber,
                'transaction_date' => now(),
            ]);

            $payout->update([
                'request_no' => $requestNumber,
                'wallet_transaction_id' => $walletTransaction->id,
            ]);

            return $payout;
        });

        return redirect()->route('payout.list')
            ->with('success', "Payout request {$payout->request_no} submitted to admin successfully.");
    }

    public function index(Request $request): View
    {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
            'status' => ['nullable', Rule::in(['Pending', 'Approved', 'Rejected'])],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::findOrFail(Auth::id());
        $baseQuery = PayoutRequest::where('user_id', $user->id);

        $payouts = (clone $baseQuery)
            ->when($request->filled('from_date'), fn ($query) => $query->whereDate('created_at', '>=', $request->from_date))
            ->when($request->filled('to_date'), fn ($query) => $query->whereDate('created_at', '<=', $request->to_date))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('request_no', 'like', "%{$search}%")
                        ->orWhere('payment_transaction_id', 'like', "%{$search}%")
                        ->orWhere('mode', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.payout-list', [
            'payouts' => $payouts,
            'totalRequests' => (clone $baseQuery)->count(),
            'pendingAmount' => (float) (clone $baseQuery)->where('status', 'Pending')->sum('amount'),
            'approvedAmount' => (float) (clone $baseQuery)->where('status', 'Approved')->sum('net_amount'),
            'rejectedAmount' => (float) (clone $baseQuery)->where('status', 'Rejected')->sum('amount'),
        ]);
    }
}
