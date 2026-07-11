@extends('layouts.admin')

@section('title', 'Earning Wallet Transactions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Earning Wallet Transactions</h3>
            <p class="text-muted mb-0">View all earning-wallet credits and debits for members.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by member / reference / description" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Credit" {{ request('type') === 'Credit' ? 'selected' : '' }}>Credit</option>
                        <option value="Debit" {{ request('type') === 'Debit' ? 'selected' : '' }}>Debit</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Reference</th>
                            <th>Opening</th>
                            <th>Closing</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                                <td>
                                    <div class="fw-bold">{{ $transaction->user->name ?? '-' }}</div>
                                    <div class="small text-muted">{{ $transaction->user->mobile ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $transaction->type === 'Credit' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $transaction->type }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ $transaction->description ?? '-' }}</td>
                                <td>{{ $transaction->reference_no ?? '-' }}</td>
                                <td>₹{{ number_format($transaction->opening_balance, 2) }}</td>
                                <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                                <td>{{ $transaction->created_at ? $transaction->created_at->format('d M Y h:i A') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No earning wallet transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
