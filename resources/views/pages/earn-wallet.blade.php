@extends('layouts.app')

@section('title', 'Earn Wallet Report')
@section('page-title', 'Earn Wallet Report')

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
.badge-income{background:#dff7e8;color:#198754}
.badge-transfer{background:#fde2e2;color:#dc3545}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Earn Wallet Balance</p><h3>₹{{ number_format($currentBalance, 2) }}</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Income</p><h3 class="text-success">₹{{ number_format($totalCredit, 2) }}</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Transfer / Payout</p><h3 class="text-danger">₹{{ number_format($totalDebit, 2) }}</h3></div></div>
      <div class="col-lg-3 col-md-6"><div class="card-box stat-card"><p>Total Records</p><h3>{{ $transactions->count() }}</h3></div></div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Earn Wallet Report</h5>

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
            <label class="form-label">Income Type</label>
            <select class="form-select" id="incomeFilter">
              <option value="">All Income Type</option>
              <option value="START UP PACKAGE LEVEL COMMISSION">START UP PACKAGE LEVEL COMMISSION</option>
              <option value="Mobile & DTH Recharge Cashback and Team Bonus">Mobile & DTH Recharge Cashback and Team Bonus</option>
              <option value="Zenith Package Return Benefit">Zenith Package Return Benefit</option>
              <option value="Product Repurchase Discount and Network Bonus">Product Repurchase Discount and Network Bonus</option>
              <option value="Monthly Zenith Pool income">Monthly Zenith Pool income</option>
              <option value="Zenith Non-Working Global Pool Income">Zenith Non-Working Global Pool Income</option>
              <option value="Zenith Team package Commission">Zenith Team package Commission</option>
              <option value="Zenith Package Sponsor Global Pool Income">Zenith Package Sponsor Global Pool Income</option>
              <option value="BUSINESS EXPANSION INCENTIVE BONUS">BUSINESS EXPANSION INCENTIVE BONUS</option>
              <option value="Leadership Achievement Bonus">Leadership Achievement Bonus</option>
              <option value="Transfer To Payout">Transfer To Payout</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-6">
            <label class="form-label">Txn Type</label>
            <select class="form-select" id="typeFilter">
              <option value="">All Type</option>
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>

          <div class="col-lg-4 col-md-6">
            <label class="form-label">Search</label>
            <input type="text" class="form-control" id="searchBox" placeholder="Txn ID / From Member / Remark">
          </div>

          <div class="col-lg-8 d-flex gap-2 flex-wrap">
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
        <h5 class="fw-bold mb-2">Earn Wallet Transactions</h5>
        <small class="text-muted">Income credit and payout transfer records</small>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="earnTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Txn ID</th>
              <th>Income Type</th>
              <th>From Member</th>
              <th>Level</th>
              <th>Credit</th>
              <th>Debit</th>
              <th>Balance</th>
              <th>Type</th>
              <th>Status</th>
              <th>Remark</th>
            </tr>
          </thead>

          <tbody>
            @forelse($transactions as $index => $transaction)
              <tr data-date="{{ $transaction->created_at?->format('Y-m-d') }}" data-income="{{ $transaction->description }}" data-type="{{ $transaction->type }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->created_at?->format('d M Y') ?? '-' }}</td>
                <td>{{ $transaction->reference_no ?? 'EW-' . $transaction->id }}</td>
                <td>{{ $transaction->description ?? '-' }}</td>
                <td>{{ optional($transaction->user)->member_id ?? 'Self' }}</td>
                <td>{{ str_contains($transaction->description ?? '', 'Level') ? 'Level ' . str_replace(['Level ', ' commission for'], '', explode(' commission for', $transaction->description ?? '')[0]) : '-' }}</td>
                <td class="credit">{{ $transaction->type === 'Credit' ? '₹' . number_format($transaction->amount, 2) : '-' }}</td>
                <td class="debit">{{ $transaction->type === 'Debit' ? '₹' . number_format($transaction->amount, 2) : '-' }}</td>
                <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                <td><span class="badge {{ $transaction->type === 'Credit' ? 'badge-income' : 'badge-transfer' }}">{{ $transaction->type }}</span></td>
                <td><span class="badge bg-success">Success</span></td>
                <td>{{ $transaction->description ?? '-' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="12" class="text-center text-muted py-4">No earning wallet transactions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <small id="resultCount">Showing {{ $transactions->count() }} transactions</small>
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
