@extends('layouts.app')

@section('title','KYC Verification')
@section('page-title','KYC Verification')

@section('content')

<div class="card-box">

    <h4 class="fw-bold mb-4">
        KYC & Bank Details
    </h4>

    <form action="{{ route('kyc.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="row g-4">

            <div class="col-12">
                <h5>PAN Details</h5>
            </div>

            <div class="col-md-6">
                <label>PAN Number</label>

                <input
                    type="text"
                    name="pan_number"
                    class="form-control"
                    value="{{ old('pan_number',$kyc->pan_number) }}">
            </div>

            <div class="col-md-6">
                <label>PAN Image</label>

                <input
                    type="file"
                    name="pan_image"
                    class="form-control">

                @if($kyc->pan_image)

                    <img src="{{ asset($kyc->pan_image) }}"
                         class="img-thumbnail mt-2"
                         width="120">

                @endif

            </div>

            <div class="col-12 mt-4">
                <h5>Aadhaar Details</h5>
            </div>

            <div class="col-md-6">
                <label>Aadhaar Number</label>

                <input
                    type="text"
                    name="aadhaar_number"
                    class="form-control"
                    value="{{ old('aadhaar_number',$kyc->aadhaar_number) }}">
            </div>

            <div class="col-md-6">
                <label>Aadhaar Front</label>

                <input
                    type="file"
                    name="aadhaar_front"
                    class="form-control">

                @if($kyc->aadhaar_front)

                    <img src="{{ asset($kyc->aadhaar_front) }}"
                         width="120"
                         class="img-thumbnail mt-2">

                @endif

            </div>

            <div class="col-md-6">
                <label>Aadhaar Back</label>

                <input
                    type="file"
                    name="aadhaar_back"
                    class="form-control">

                @if($kyc->aadhaar_back)

                    <img src="{{ asset($kyc->aadhaar_back) }}"
                         width="120"
                         class="img-thumbnail mt-2">

                @endif

            </div>

            <div class="col-12 mt-4">
                <h5>Bank Details</h5>
            </div>

            <div class="col-md-6">
                <label>Account Holder Name</label>

                <input
                    type="text"
                    name="account_holder_name"
                    class="form-control"
                    value="{{ old('account_holder_name',$kyc->account_holder_name) }}">
            </div>

            <div class="col-md-6">
                <label>Bank Name</label>

                <input
                    type="text"
                    name="bank_name"
                    class="form-control"
                    value="{{ old('bank_name',$kyc->bank_name) }}">
            </div>

            <div class="col-md-6">
                <label>Account Number</label>

                <input
                    type="text"
                    name="account_number"
                    class="form-control"
                    value="{{ old('account_number',$kyc->account_number) }}">
            </div>

            <div class="col-md-6">
                <label>IFSC Code</label>

                <input
                    type="text"
                    name="ifsc_code"
                    class="form-control"
                    value="{{ old('ifsc_code',$kyc->ifsc_code) }}">
            </div>

            <div class="col-md-6">
                <label>Branch Name</label>

                <input
                    type="text"
                    name="branch_name"
                    class="form-control"
                    value="{{ old('branch_name',$kyc->branch_name) }}">
            </div>

            <div class="col-md-6">
                <label>Passbook / Cancelled Cheque</label>

                <input
                    type="file"
                    name="passbook_image"
                    class="form-control">

                @if($kyc->passbook_image)

                    <a href="{{ asset($kyc->passbook_image) }}"
                       target="_blank"
                       class="btn btn-sm btn-success mt-2">
                        View Uploaded File
                    </a>

                @endif

            </div>

            <div class="col-12 mt-4">

                <button class="btn btn-main">

                    Save KYC

                </button>

            </div>

        </div>

    </form>

</div>

@endsection