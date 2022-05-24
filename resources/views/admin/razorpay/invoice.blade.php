@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row invoice layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="app-hamburger-container">
                    <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-menu chat-menu d-xl-none">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg></div>
                </div>
                <div class="doc-container">
                    <div class="tab-title">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="search">
                                    <input type="text" class="form-control" placeholder="Invoice" disabled>
                                </div>
                                <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <div class="nav-link list-actions" id="invoice-{{ $transaction->id }}"
                                            data-invoice-id="{{ sprintf('%08d', $transaction->id) }}">
                                            <div class="f-m-body">

                                                <div class="f-body">
                                                    <p class="invoice-number">Invoice
                                                        #{{ sprintf('%08d', $transaction->id) }}</p>
                                                    <p class="invoice-customer-name"><span>To:</span>
                                                        {{ $transaction->customer->name }}</p>
                                                    <p class="invoice-generated-date">Date:
                                                        {{ $transaction->created_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-container">
                        <div class="invoice-inbox">

                            <div class="inv-not-selected">
                                <p>Open an invoice from the list.</p>
                            </div>

                            <div class="invoice-header-section">
                                <h4 class="inv-number"></h4>
                                <div class="invoice-action">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-printer action-print"
                                        data-toggle="tooltip" data-placement="top" data-original-title="Reply">
                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                        <path
                                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                        </path>
                                        <rect x="6" y="14" width="12" height="8"></rect>
                                    </svg>
                                </div>
                            </div>

                            <div id="ct" class="">

                                <div class="invoice-{{ $transaction->id }}">
                                    <div class="content-section  animated animatedFadeInUp fadeInUp">

                                        <div class="row inv--head-section mb-4">

                                            <div class="col-sm-6 col-12">
                                                <h3 class="in-heading">INVOICE</h3>
                                            </div>
                                            <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                                <div class="company-info">

                                                    <img src="{{ asset('common_assets/img/logo_dark.png') }}"
                                                        height="45" alt="">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row inv--detail-section">

                                            <div class="col-sm-7 align-self-center">
                                                <p class="inv-to">Invoice To</p>
                                                <p class="inv-customer-name">Customer Name :
                                                    {{ $transaction->customer->name }}</p>
                                                <p class="inv-customer-name">Shop Name :
                                                    {{ $transaction->customer->customer_details->store_name }}</p>
                                                <p class="inv-street-addr"> Main Address :
                                                    {{ $transaction->customer->customer_details->address }}
                                                </p>
                                                <p class="inv-email-address">Customer Email :
                                                    {{ $transaction->customer->email }}</p>
                                                <p class="inv-street-addr">
                                                    {{ $transaction->customer->customer_details->gstin? "Customer GSTIN#".$transaction->customer->customer_details->gstin:"" }}
                                                </p>
                                                <p class="inv-street-addr">
                                                    {{ $transaction->customer->customer_details->gstin? "Customer Place of Supply: ".$transaction->customer->customer_details->pos:"" }}
                                                </p>
                                            </div>
                                            <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                                <p class="inv-to">Invoice From</p>
                                                <p class="inv-street-addr">9vn Communication pvt ltd <br>
                                                    GSTIN# 21AABCZ4505D1ZW <br>
                                                    3rd Floor SRC 201, Bapuji Nagar ,<br> Bhubaneswar,<br> Odisha
                                                    751009
                                                </p>
                                            </div>

                                            <div class="col-sm-7 align-self-center">

                                            </div>
                                            <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                                <p class="inv-list-number"><span class="inv-title">Invoice Number :
                                                    </span> <span class="inv-number">[invoice number]</span></p>
                                                <p class="inv-created-date"><span class="inv-title">Invoice Date :
                                                    </span> <span class="inv-date">{{ $transaction->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row inv--product-table-section">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">S.No</th>
                                                                <th scope="col">Items</th>
                                                                <th class="text-right" scope="col">Qty</th>
                                                                <th class="text-right" scope="col">Unit Price</th>
                                                                <th class="text-right" scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td>1</td>
                                                                <td>{{ $transaction->customer->customer_details->package->title }}
                                                                </td>
                                                                <td class="text-right">1</td>
                                                                <td class="text-right">
                                                                    ₹{{ $transaction->customer->customer_details->package->price }}
                                                                </td>
                                                                <td class="text-right">
                                                                    ₹{{ $transaction->customer->customer_details->package->price }}
                                                                </td>
                                                            </tr>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                <div class="inv--payment-info">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-12">
                                                            <h6 class=" inv-title">Payment Info:</h6>
                                                        </div>
                                                        <div class="col-sm-4 col-12">
                                                            <p class=" inv-subtitle">Transaction Method: </p>
                                                        </div>
                                                        <div class="col-sm-8 col-12">
                                                            <p class="">
                                                                {{ $transaction->first()->payment_type == 0 ? "Cash Payment" : ($transaction->first()->payment_type == 1 ? "Payment Gateway" : ($transaction->first()->payment_type == 2 ? "UPI" : ($transaction->first()->payment_type == 3 ? "Internet banking" : ($transaction->first()->payment_type == 4 ? "Paytm" : ($transaction->first()->payment_type == 5 ? "Commission Basis" : "N/A") ))) ) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-4 col-12">
                                                            <p class=" inv-subtitle">Transaction Number</p>
                                                        </div>
                                                        <div class="col-sm-8 col-12">
                                                            <p class="">
                                                                {{ $transaction->transaction_id }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                <div class="inv--total-amounts text-sm-right">
                                                    <div class="row">
                                                        <div class="col-sm-8 col-7">
                                                            <p class="">Sub Total: </p>
                                                        </div>
                                                        <div class="col-sm-4 col-5">
                                                            <p class="">
                                                                ₹{{ $transaction->amount }}</p>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <p class="">Tax Amount (GST {{ $gst->value."%" }}):

                                                            </p>
                                                        </div>
                                                        <div class="col-sm-4 col-5">
                                                            <p class="">₹{{ $transaction->tax }}</p>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <p class=" discount-rate">Discount : <span
                                                                    class="discount-percentage">0%</span> </p>
                                                        </div>
                                                        <div class="col-sm-4 col-5">
                                                            <p class="">₹0</p>
                                                        </div>
                                                        <div class="col-sm-8 col-7 grand-total-title">
                                                            <h4 class="">Grand Total : </h4>
                                                        </div>
                                                        <div class="col-sm-4 col-5 grand-total-amount">
                                                            <h4 class="">
                                                                ₹{{ $transaction->total_amount }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="inv--thankYou">
                            <div class="row">
                                <div class="col-sm-12 col-12">
                                    <p class="">Thank you for doing Business with us.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    @include('admin.includes.footer')
</div>
<!--  END CONTENT AREA  -->

@endsection

@section('scripts')
<script src="{{ asset('admin_assets/js/apps/invoice.js') }}"></script>
@endsection
