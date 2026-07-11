@extends('layouts.app')

@section('title','Change Password')
@section('page-title','Change Password')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-6">

        <div class="card-box">

            <h4 class="fw-bold mb-4">
                Change Password
            </h4>

            <form action="{{ route('change.password.update') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Current Password
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Enter Current Password">

                    @error('current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter New Password">

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm Password">
                </div>

                <div class="d-flex gap-2">

                    <button class="btn btn-main">
                        <i class="fas fa-key me-2"></i>
                        Update Password
                    </button>

                    <a href="{{ route('profile') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection