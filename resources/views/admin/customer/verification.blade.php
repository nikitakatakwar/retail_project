@extends('admin.layout.default')

@section('title')

@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/tables/table-basic.css') }}"rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Phone Number Verification</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('customer.index') }}">Manage Customer</a></li>
                                    <li class="active mb-2"><a href="#">SMS Verification</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('customer.otp.submit') }}">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Phone Number</label>
                                            <input type="text" value="{{ $customer->phone_numbers['number'] }}"
                                                class="form-control" id="name" placeholder="Enter Full Name" readonly>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Enter OTP</label>
                                            <input type="text" name="otp" value="{{ old('otp') }}" class="form-control"
                                                id="otp" placeholder="Enter OTP" required>
                                            @error('otp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <button type="Submit" class="btn btn-primary">Submit OTP</button>
                                        <a href=""
                                            class="btn btn-secondary">Send OTP</a>
                                        <a href="{{ route('customer.index') }}" class="btn btn-warning">Back</a>
                                        @can(['show admin verify'])
                                        <a href="{{ route('customer.admin.verify',$customer->id) }}"
                                            class="btn btn-danger float-right">Verified
                                            By Admin</a>
                                        @endcan

                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

<!--  END CONTENT AREA  -->
@endsection

@section('scripts')

@endsection
