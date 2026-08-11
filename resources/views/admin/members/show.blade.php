@extends('layouts.admin')

@section('title', 'Manage Member')
@section('page-title', 'Manage Member')

@push('styles')
<style>
  .member-page{--member-ink:#182235;--member-muted:#6b7280;--member-line:#e8edf3;--member-soft:#f5f7fa}
  .member-page .member-hero{position:relative;overflow:hidden;background:linear-gradient(135deg,#182235 0%,#29364b 100%);color:#fff;border-radius:18px;padding:25px 28px;box-shadow:0 16px 36px rgba(24,34,53,.16)}
  .member-page .member-hero:after{content:"";position:absolute;width:210px;height:210px;border:42px solid rgba(255,255,255,.04);border-radius:50%;right:-45px;top:-80px}
  .member-avatar{width:58px;height:58px;display:grid;place-items:center;border-radius:16px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);font-size:22px;font-weight:800;flex:0 0 auto}
  .member-eyebrow{color:#aeb8c8;font-size:12px;font-weight:700;letter-spacing:.09em;text-transform:uppercase}
  .member-meta{display:flex;flex-wrap:wrap;gap:8px 18px;color:#d4dae3;font-size:13px}
  .member-meta i{width:15px;color:#94a3b8}
  .member-status{padding:8px 13px;border-radius:999px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.15);font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}
  .member-page .surface{background:#fff;border:1px solid var(--member-line);border-radius:16px;box-shadow:0 8px 26px rgba(24,34,53,.055)}
  .surface-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:19px 21px;border-bottom:1px solid var(--member-line)}
  .surface-head h5{font-size:15px;font-weight:800;color:var(--member-ink);margin:0}
  .surface-head p{font-size:12px;color:var(--member-muted);margin:3px 0 0}
  .surface-body{padding:21px}
  .wallet-card{height:100%;padding:20px 21px;border-radius:16px;border:1px solid var(--member-line);background:#fff;box-shadow:0 8px 24px rgba(24,34,53,.05);position:relative;overflow:hidden}
  .wallet-card:after{content:"";position:absolute;width:90px;height:90px;border-radius:50%;right:-35px;bottom:-40px;background:currentColor;opacity:.06}
  .wallet-card.main-wallet{color:#2563eb}.wallet-card.earning-wallet{color:#059669}
  .wallet-icon{width:42px;height:42px;display:grid;place-items:center;border-radius:12px;background:currentColor;color:#fff;font-size:17px}
  .wallet-label{font-size:12px;color:var(--member-muted);font-weight:700;text-transform:uppercase;letter-spacing:.06em}
  .wallet-amount{font-size:26px;font-weight:850;color:var(--member-ink);line-height:1.2;margin-top:5px}
  .member-detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 26px}
  .member-detail{padding:12px 0;border-bottom:1px solid var(--member-line);min-width:0}
  .member-detail:nth-last-child(-n+2){border-bottom:0}
  .member-detail small{display:block;color:var(--member-muted);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px}
  .member-detail strong{display:block;color:var(--member-ink);font-size:14px;overflow-wrap:anywhere}
  .section-icon{width:37px;height:37px;display:grid;place-items:center;border-radius:10px;background:#eef2f7;color:#334155}
  .wallet-form-shell{background:var(--member-soft);border:1px solid var(--member-line);border-radius:13px;padding:17px}
  .wallet-form-shell .form-label{font-size:12px;font-weight:750;color:#475569;margin-bottom:6px}
  .wallet-form-shell .form-control,.wallet-form-shell .form-select{border:1px solid #dce3eb;box-shadow:none;min-height:43px}
  .wallet-form-shell textarea.form-control{min-height:82px}
  .wallet-tip{display:flex;gap:10px;padding:11px 13px;border-radius:10px;background:#fff;border:1px dashed #d4dce7;color:#64748b;font-size:12px;line-height:1.45}
  .compact-form .form-label{font-size:12px;font-weight:700;color:#64748b}
  .activity-table{margin:0;white-space:nowrap}
  .activity-table thead th{font-size:11px!important;letter-spacing:.05em;text-transform:uppercase;padding:12px 14px!important}
  .activity-table tbody td{padding:13px 14px;font-size:13px;color:#475569;vertical-align:middle}
  .activity-table .details-cell{white-space:normal;min-width:210px}
  .transaction-type{display:inline-flex;align-items:center;gap:6px;padding:5px 9px;border-radius:999px;font-size:11px;font-weight:800}
  .transaction-type.credit{background:#dcfce7;color:#167044}.transaction-type.debit{background:#fee2e2;color:#b42318}
  .empty-activity{padding:34px 20px!important;text-align:center;color:#94a3b8!important}
  @media(max-width:767px){.member-page .member-hero{padding:21px}.member-detail-grid{grid-template-columns:1fr}.member-detail:nth-last-child(2){border-bottom:1px solid var(--member-line)}.wallet-amount{font-size:23px}.surface-head,.surface-body{padding:17px}}
</style>
@endpush

@section('content')
<div class="member-page">
  <div class="member-hero mb-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative" style="z-index:1">
      <div class="d-flex align-items-center gap-3">
        <div class="member-avatar">{{ strtoupper(substr($member->name ?: 'M', 0, 1)) }}</div>
        <div>
          <div class="member-eyebrow mb-1">Member profile</div>
          <h3 class="fw-bold mb-2">{{ $member->name }}</h3>
          <div class="member-meta">
            <span><i class="fa fa-id-badge"></i>{{ $member->member_id ?? 'ID not assigned' }}</span>
            <span><i class="fa fa-phone"></i>{{ $member->mobile ?? 'No mobile' }}</span>
            <span><i class="fa fa-calendar"></i>Joined {{ optional($member->created_at)->format('d M Y') ?? '-' }}</span>
          </div>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="member-status"><i class="fa fa-circle me-2" style="font-size:7px;color:{{ ($member->status ?? 'Active') === 'Active' ? '#4ade80' : '#fbbf24' }}"></i>{{ $member->status ?? 'Active' }}</span>
        <a href="{{ route('admin.members.index') }}" class="btn btn-light btn-sm rounded-pill px-3"><i class="fa fa-arrow-left me-1"></i> Members</a>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="wallet-card main-wallet">
        <div class="d-flex align-items-center gap-3">
          <div class="wallet-icon"><i class="fa fa-wallet"></i></div>
          <div><div class="wallet-label">Main wallet balance</div><div class="wallet-amount">₹{{ number_format($member->main_wallet ?? 0, 2) }}</div></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="wallet-card earning-wallet">
        <div class="d-flex align-items-center gap-3">
          <div class="wallet-icon"><i class="fa fa-coins"></i></div>
          <div><div class="wallet-label">Earning wallet balance</div><div class="wallet-amount">₹{{ number_format($member->earning_wallet ?? 0, 2) }}</div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 align-items-start">
    <div class="col-xl-8">
      <div class="surface mb-4">
        <div class="surface-head">
          <div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa fa-user"></i></span><div><h5>Member information</h5><p>Account and sponsorship details</p></div></div>
        </div>
        <div class="surface-body">
          <div class="member-detail-grid">
            <div class="member-detail"><small>Full name</small><strong>{{ $member->name }}</strong></div>
            <div class="member-detail"><small>Member ID</small><strong>{{ $member->member_id ?? '-' }}</strong></div>
            <div class="member-detail"><small>Email address</small><strong>{{ $member->email ?? '-' }}</strong></div>
            <div class="member-detail"><small>Mobile number</small><strong>{{ $member->mobile ?? '-' }}</strong></div>
            <div class="member-detail"><small>Sponsor ID</small><strong>{{ $member->sponsor_id ?? '-' }}</strong></div>
            <div class="member-detail"><small>Current package</small><strong>{{ $member->package_name ?? 'No active package' }}</strong></div>
          </div>
        </div>
      </div>

      <div class="surface mb-4">
        <div class="surface-body d-flex justify-content-between align-items-center flex-wrap gap-3">
          <div>
            <strong class="d-block mb-1">Member login</strong>
            <span class="small text-muted">{{ $member->email ?? $member->mobile ?? 'No login ID available' }}</span>
          </div>
          <form method="POST" action="{{ route('admin.members.login', $member) }}" onsubmit="return confirm('Log in as {{ addslashes($member->name) }}?');">
            @csrf
            <button class="btn btn-main px-4"><i class="fa fa-right-to-bracket me-2"></i>Log in as member</button>
          </form>
        </div>
      </div>

      <div class="surface mb-4">
        <div class="surface-head">
          <div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa fa-money-bill-transfer"></i></span><div><h5>Wallet adjustment</h5><p>Credit or debit the member's selected wallet</p></div></div>
        </div>
        <div class="surface-body">
          <form method="POST" action="{{ route('admin.members.wallet-adjustment', $member) }}" onsubmit="return confirm('Confirm this wallet adjustment? This action will be recorded in transaction history.');">
            @csrf
            <div class="wallet-form-shell">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">Select wallet</label>
                  <select name="wallet" class="form-select @error('wallet') is-invalid @enderror" required>
                    <option value="main" @selected(old('wallet') === 'main')>Main Wallet</option>
                    <option value="earning" @selected(old('wallet') === 'earning')>Earning Wallet</option>
                  </select>
                  @error('wallet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                  <label class="form-label">Transaction type</label>
                  <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="Credit" @selected(old('type') === 'Credit')>Credit (+)</option>
                    <option value="Debit" @selected(old('type') === 'Debit')>Debit (−)</option>
                  </select>
                  @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                  <label class="form-label">Amount (₹)</label>
                  <input type="number" name="amount" value="{{ old('amount') }}" min="0.01" max="9999999999.99" step="0.01" placeholder="0.00" class="form-control @error('amount') is-invalid @enderror" required>
                  @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                  <label class="form-label">Reason / remarks</label>
                  <textarea name="remarks" maxlength="500" class="form-control @error('remarks') is-invalid @enderror" placeholder="Describe why this adjustment is being made..." required>{{ old('remarks') }}</textarea>
                  @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                  <div class="wallet-tip"><i class="fa fa-shield-halved mt-1"></i><span>Debits cannot exceed the available balance. Every change is permanently recorded.</span></div>
                  <button class="btn btn-main px-4 py-2"><i class="fa fa-check me-2"></i>Apply adjustment</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>

    <div class="col-xl-4">
      <div class="surface mb-4">
        <div class="surface-head"><div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa fa-id-card"></i></span><div><h5>KYC summary</h5><p>Verification and bank details</p></div></div></div>
        <div class="surface-body">
          <div class="member-detail"><small>Verification status</small><strong><span class="badge bg-secondary">{{ $member->kyc->status ?? 'Not Submitted' }}</span></strong></div>
          <div class="member-detail"><small>PAN number</small><strong>{{ $member->kyc->pan_number ?? '-' }}</strong></div>
          <div class="member-detail"><small>Aadhaar number</small><strong>{{ $member->kyc->aadhaar_number ?? '-' }}</strong></div>
          <div class="member-detail"><small>Bank name</small><strong>{{ $member->kyc->bank_name ?? '-' }}</strong></div>
          <a href="{{ route('admin.kyc.index', ['search' => $member->member_id]) }}" class="btn btn-outline-dark rounded-pill w-100 mt-3"><i class="fa fa-arrow-up-right-from-square me-2"></i>Open KYC record</a>
        </div>
      </div>

      <div class="surface mb-4">
        <div class="surface-head"><div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa fa-toggle-on"></i></span><div><h5>Account status</h5><p>Control member access</p></div></div></div>
        <div class="surface-body compact-form">
          <form method="POST" action="{{ route('admin.members.status', $member) }}">
            @csrf @method('PATCH')
            <label class="form-label">Current status</label>
            <select name="status" class="form-select mb-3" required>@foreach(['Active','Inactive','Blocked'] as $status)<option value="{{ $status }}" @selected(($member->status ?? 'Active') === $status)>{{ $status }}</option>@endforeach</select>
            <button class="btn btn-main w-100">Save account status</button>
          </form>
        </div>
      </div>

      <div class="surface">
        <div class="surface-head"><div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa fa-lock"></i></span><div><h5>Reset password</h5><p>Set new login credentials</p></div></div></div>
        <div class="surface-body compact-form">
          <form method="POST" action="{{ route('admin.members.password', $member) }}">
            @csrf @method('PATCH')
            <div class="mb-3"><label class="form-label">New password</label><input type="password" name="password" minlength="8" class="form-control" placeholder="Minimum 8 characters" required></div>
            <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" minlength="8" class="form-control" placeholder="Repeat new password" required></div>
            <button class="btn btn-outline-dark rounded-pill w-100"><i class="fa fa-key me-2"></i>Reset password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mt-1">
    @foreach([['Main wallet activity', $mainWalletTransactions, 'transaction_type', 'particular', 'fa-wallet'], ['Earning wallet activity', $earningWalletTransactions, 'type', 'description', 'fa-coins']] as [$title, $transactions, $typeField, $detailField, $icon])
      <div class="col-12 col-xxl-6">
        <div class="surface h-100">
          <div class="surface-head"><div class="d-flex align-items-center gap-3"><span class="section-icon"><i class="fa {{ $icon }}"></i></span><div><h5>{{ $title }}</h5><p>Last 10 recorded transactions</p></div></div></div>
          <div class="table-responsive">
            <table class="table activity-table">
              <thead><tr><th>Date</th><th>Type</th><th>Amount</th><th>Balance</th><th>Details</th></tr></thead>
              <tbody>
                @forelse($transactions as $transaction)
                  @php($isCredit = strtolower($transaction->{$typeField}) === 'credit')
                  <tr>
                    <td>{{ optional($transaction->transaction_date ?? $transaction->created_at)->format('d M Y') }}</td>
                    <td><span class="transaction-type {{ $isCredit ? 'credit' : 'debit' }}"><i class="fa {{ $isCredit ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>{{ $transaction->{$typeField} }}</span></td>
                    <td class="fw-bold {{ $isCredit ? 'text-success' : 'text-danger' }}">{{ $isCredit ? '+' : '−' }}₹{{ number_format($transaction->amount, 2) }}</td>
                    <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                    <td class="details-cell">{{ $transaction->{$detailField} ?: '-' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="empty-activity"><i class="fa fa-clock-rotate-left d-block fs-4 mb-2"></i>No wallet transactions yet</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
