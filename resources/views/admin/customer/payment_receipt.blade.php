@extends('admin.layout.default')

@section('title')

@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/tables/table-basic.css') }}"" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Payment Receipt</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('customer.index') }}">Manage Customer</a></li>
                                    <li class="active mb-2"><a href="#">Payment Receipt</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(!isset($payment_receipt))
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('customer.payment.receipt.submit',$customer->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Phone Number</label>

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

                                        <a href="{{ route('customer.index') }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <strong>Customer's Name : </strong>
                            {{ $payment_receipt->customer?$payment_receipt->customer->name : "N/A" }} <br>
                            <strong>Executive's Name : </strong>
                            {{ $payment_receipt->employee?$payment_receipt->employee->name : "N/A" }} <br>
                            <strong>Received By : </strong>
                            {{ $payment_receipt->receiver?$payment_receipt->receiver->name : "N/A" }} <br>
                            <strong>Amount : </strong> Rs. {{ $payment_receipt->amount }} <br>
                            <strong>Date : </strong> {{ $payment_receipt->created_at }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
<!--  END CONTENT AREA  -->
@endsection

@section('scripts')

@endsection
