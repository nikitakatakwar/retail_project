@extends('admin.layout.default')


@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/tables/table-basic.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets//css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:700px;">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Subscription Payment</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('customer.index') }}">Manage Customer</a></li>
                                    <li class="active mb-2"><a href="#">Make Payment</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 layout-spacing">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bio layout-spacing">
                                        <div class="widget-content widget-content-area">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Payment Information</h3>
                                                    <table
                                                        class="table table-sm table-bordered table-hover table-striped mb-4 ">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <h5> {{ $customer->customer_details->package->title }}
                                                                    </h5>
                                                                </td>
                                                                <td>
                                                                    <h5>Rs.{{ $customer->customer_details->package->price }}
                                                                    </h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h5> GST</h5>
                                                                </td>
                                                                <td>
                                                                    <h5>Rs.{{ $customer->customer_details->package->price *  ($gst->value/100) }}
                                                                    </h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h5>Total

                                                                    </h5>
                                                                </td>
                                                                <td>
                                                                    <h5>
                                                                        Rs.{{ $customer->customer_details->package->price +  ($customer->customer_details->package->price *  ($gst->value/100))}}
                                                                    </h5>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="bio layout-spacing">
                                        <div class="widget-content widget-content-area">
                                            <div class="row">
                                                <div class="col-md-12 pb-3">
                                                    <h3>Online Payment Gateway</h3>
                                                    <a href="javascript:void(0)" class="btn btn-primary" id="buy_now"
                                                        data-passing-amout="{{ $customer->customer_details->package->price }}"
                                                        data-amount="{{ $customer->customer_details->package->price +  ($customer->customer_details->package->price *  ($gst->value/100)) }}"
                                                        data-id={{ $customer->customer_details->package->id }}>Buy
                                                        Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bio layout-spacing">
                                        <div class="widget-content widget-content-area">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Offline Payment </h3>
                                                    <form method="POST"
                                                        action="{{ route('customer.transaction.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="customer_id"
                                                            value="{{ $customer->id }}">
                                                        <input type="hidden" name="amount"
                                                            value="{{ $customer->customer_details->package->price }}">
                                                        <input type="hidden" name="total_amount"
                                                            value="{{ $customer->customer_details->package->price +  ($customer->customer_details->package->price *  ($gst->value/100)) }}">
                                                        <input type="hidden" name="tax"
                                                            value="{{ $customer->customer_details->package->price *  ($gst->value/100) }}">
                                                        <div class="form-group">
                                                            <label for="transaction_id">Transaction Number</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                name="transaction_id"
                                                                placeholder="Enter Transaction Number"
                                                                id="transaction_id" value="{{ old('transaction_id') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="payment_method">Select Payment Method</label>
                                                            <select class="form-control form-control-sm"
                                                                name="payment_method" id="payment_method" required>
                                                                <option>--Select Payment Method--</option>
                                                                <option value="0">Cash</option>
                                                                <option value="2">Internet Banking</option>
                                                                <option value="3">UPI</option>
                                                                <option value="4">Paytm</option>
                                                                <option value="5">Commission Basis</option>
                                                            </select>
                                                        </div>
                                                        <input type="submit" class="mb-4 btn btn-primary">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--  END CONTENT AREA  -->
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $('body').on('click', '#buy_now', function (e) {

        var totalAmount = $(this).attr("data-amount");
        var passingAmount = $(this).attr("data-passing-amout");
        var package_id = $(this).attr("data-id");
        var options = {
            "key": "{{ env('RZP_KEY_ID') }}",
            "amount": (totalAmount * 100), // 2000 paise = INR 20
            "name": "Shoppi9",
            "description": "Payment",
            "image": "{{ asset('common_assets/img/logo_dark.png') }}",
            "handler": function (response) {
                $.ajax({
                    url: "{{ route('payment.success') }}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        totalAmount: totalAmount,
                        passingAmount: passingAmount,
                        package_id: package_id,
                        customer_id: "{{ $customer->id }}"
                    },
                    success: function (msg) {

                        window.location.href = "{{ route('customer.index') }}";
                    }
                });
            },
            "prefill": {
                "contact": '1234567890',
                "email": 'xxxxxxxxx@gmail.com',
            },
            "theme": {
                "color": "#528FF0"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    });

</script>
@endsection
