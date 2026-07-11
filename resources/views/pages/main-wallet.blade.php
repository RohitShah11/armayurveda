@extends('layouts.app')

@section('title', 'Main Wallet Transaction Report')
@section('page-title', 'Main Wallet Transaction Report')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:46px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.credit{color:#198754;font-weight:800}
.debit{color:#dc3545;font-weight:800}
.badge-credit{background:#dff7e8;color:#198754}
.badge-debit{background:#fde2e2;color:#dc3545}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Current Balance</p>
          <h3>₹{{ number_format($currentBalance, 2) }}</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Credit</p>
          <h3 class="text-success">₹{{ number_format($totalCredit, 2) }}</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Debit</p>
          <h3 class="text-danger">₹{{ number_format($totalDebit, 2) }}</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total Transactions</p>
          <h3>{{ $transactions->count() }}</h3>
        </div>
      </div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Report</h5>

      <form onsubmit="filterReport(event)">
        <div class="row g-3 align-items-end">
          <div class="col-lg-3 col-md-6">
            <label class="form-label">From Date</label>
            <input type="date" class="form-control" id="fromDate">
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">To Date</label>
            <input type="date" class="form-control" id="toDate">
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Transaction Type</label>
            <select class="form-select" id="typeFilter">
              <option value="">All Type</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchBox" placeholder="Txn ID / Remark">
          </div>

          <div class="col-lg-12 d-flex gap-2 flex-wrap">
            <button class="btn btn-main"><i class="fa fa-search"></i> Search</button>
            <button type="button" class="btn btn-secondary rounded-pill px-4" onclick="resetFilter()">Reset</button>
            <button type="button" class="btn btn-gold"><i class="fa fa-file-excel"></i> Export Excel</button>
            <button type="button" class="btn btn-outline-danger rounded-pill px-4"><i class="fa fa-file-pdf"></i> Export PDF</button>
          </div>
        </div>
      </form>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h5 class="fw-bold mb-2">Main Wallet Transactions</h5>
        <small class="text-muted">Showing wallet credit and debit records</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="walletTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Txn ID</th>
              <th>Description</th>
              <th>Credit</th>
              <th>Debit</th>
              <th>Balance</th>
              <th>Type</th>
              <th>Status</th>
              <th>Remark</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($transactions as $index => $transaction)
              <tr data-date="{{ optional($transaction->transaction_date)->format('Y-m-d') }}" data-type="{{ $transaction->transaction_type }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ optional($transaction->transaction_date)->format('d M Y') }}</td>
                <td>TXN{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $transaction->particular }}</td>
                <td>
                  @if ($transaction->transaction_type === 'Credit')
                    <span class="credit">₹{{ number_format($transaction->amount, 2) }}</span>
                  @else
                    -
                  @endif
                </td>
                <td>
                  @if ($transaction->transaction_type === 'Debit')
                    <span class="debit">₹{{ number_format($transaction->amount, 2) }}</span>
                  @else
                    -
                  @endif
                </td>
                <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                <td>
                  <span class="badge {{ $transaction->transaction_type === 'Credit' ? 'badge-credit' : 'badge-debit' }}">
                    {{ $transaction->transaction_type }}
                  </span>
                </td>
                <td><span class="badge bg-success">Success</span></td>
                <td>{{ $transaction->remarks ?: '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center text-muted">No wallet transactions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <small id="resultCount">Showing 6 transactions</small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link">Previous</a></li>
            <li class="page-item active"><a class="page-link">1</a></li>
            <li class="page-item"><a class="page-link">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>

  </div>
@endsection
