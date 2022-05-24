@extends('admin.layout.default')

@section('title')

@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:900px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Create Customer User</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('customer.index') }}">Manage Customers</a></li>
                                    <li class="active mb-2"><a href="#">Customer User Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <strong>Customer General Information</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name</label> <br>
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label> <br>
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label> <br>


                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2">
                                <div class="col-md-12">
                                    <strong>Customer Other Information</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label> <br>
                                        {{ $user->customer_details['address'] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_opt">Address Optional</label> <br>
                                        {{ $user->customer_details['address_opt'] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_category_id">Business Category</label> <br>

                                        {{ $user->customer_details['business_category']['title']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_category_id">Product Category</label> <br>
                                        {{ $user->customer_details['product_category']['title']}}

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="requirements">Requirements</label> <br>
                                        {{ $user->customer_details['requirements']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="services">Services</label> <br>
                                        {{ $user->customer_details['services']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="store_name">Store Name</label> <br>
                                        {{ $user->customer_details['store_name']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label> <br>
                                        {{ $user->customer_details['state']}} </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">CIty</label> <br>
                                        {{ $user->customer_details['city']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pincode">Pincode / Postal Code</label> <br>
                                        {{ $user->customer_details['pincode']}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2">
                                <div class="col-md-12">
                                    <strong>Customer GST Information</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gstin">GSTIN</label> <br>
                                        {{ $user->customer_details['gstin']}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pos">Place of Supply</label> <br>
                                        {{ $user->customer_details['pos']}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2">
                                <div class="col-md-12">
                                    <strong>Payment Information</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package_id">Select Package</label> <br>

                                        {{ $user->customer_details['package']['title'] ." (".$user->customer_details['package']['price'].")"}}
                                    </div>
                                </div>
                            </div>


                            @if ($user->moving_status && $user->moving_status->move_status != 1 &&
                            ($user->moving_status->employee_id == Auth::user()->id ||
                            Auth::user()->hasPermissionTo('update moving status')))
                            <div class="row mt-4 mb-2">
                                <div class="col-md-12">
                                    <strong>Update Moving Status</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form method="POST" action="{{ route('move-customer.update') }}">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{ $user->id }}">
                                        <div class="form-group form-group-sm">
                                            <label for="package_id">Moving Status</label> <br>

                                            <select name="move_status" class="form-control" id="move_status" required>
                                                <option
                                                    {{ $user->moving_status && $user->moving_status->move_status == 0 ? "Selected" : "" }}
                                                    value="0">Pending</option>
                                                <option
                                                    {{ $user->moving_status && $user->moving_status->move_status == 1 ? "Selected" : "" }}
                                                    value="1">Moved</option>

                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                    </form>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
<!--  END CONTENT AREA  -->

@endsection
