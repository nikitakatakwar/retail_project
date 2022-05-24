@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection


@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:1500px;">
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
                                    <li class="active mb-2"><a href="#">Create Customer Users</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('customer.store') }}">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <strong>Customer General Information</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" id="name" placeholder="Enter Full Name" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                class="form-control" id="email" placeholder="Enter Email" required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                                class="form-control" id="phone_number" placeholder="Enter Phone Number"
                                                required>
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Enter Password" required>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Enter Password again"
                                                required>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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
                                            <label for="address">Address</label>
                                            <textarea name="address" class="form-control" rows="4" id="address"
                                                placeholder="Enter address" required>{{ old('address') }}</textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_opt">Address Optional</label>
                                            <textarea name="address_opt" class="form-control" rows="4" id="address_opt"
                                                placeholder="Enter Optional Address">{{ old('address_opt') }}</textarea>
                                            @error('address_opt')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="business_category_id">Business Category</label>
                                            <select name="business_category_id" class="form-control"
                                                id="business_category_id" required>
                                                <option value="">--Select Category--</option>
                                                @foreach ($business_categories as $business_category)
                                                <option
                                                    {{ old('business_category_id') == $business_category->id ? "selected" : "" }}
                                                    value="{{ $business_category->id }}">{{ $business_category->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('business_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Product Category</label>
                                            <select name="product_category_id" class="form-control"
                                                id="product_category_id" required>
                                                <option value="">--Select Category--</option>
                                                @foreach ($product_categories as $product_category)
                                                <option
                                                    {{ old('product_category_id') == $product_category->id ? "selected" : "" }}
                                                    value="{{ $product_category->id }}">{{ $product_category->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('product_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="requirements">Requirements</label>
                                            <textarea name="requirements" class="form-control" rows="4"
                                                id="requirements"
                                                placeholder="Enter Requirements">{{ old('requirements') }}</textarea>
                                            @error('requirements')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="services">Services</label>
                                            <textarea name="services" class="form-control" rows="4" id="services"
                                                placeholder="Enter Services">{{ old('services') }}</textarea>
                                            @error('services')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store_name">Store Name</label>
                                            <input type="text" name="store_name" value="{{ old('store_name') }}"
                                                class="form-control" id="store_name" placeholder="Enter Store Name"
                                                required>
                                            @error('store_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <select name="state" class="form-control" id="state" required>
                                                <option value="">--Select State--</option>
                                                <option {{ old('state') == "Odisha" ? "selected" : "" }} value="Odisha">
                                                    Odisha</option>
                                            </select>
                                            @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">CIty</label>
                                            <select name="city" class="form-control" id="city" required>
                                                <option value="">--Select City--</option>
                                                @foreach ($cities as $city)
                                                <option {{ old('city') == $city->name ? "selected" : "" }}
                                                    value="{{ $city->name }}">
                                                    {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pincode">Pincode / Postal Code</label>
                                            <input type="text" name="pincode" value="{{ old('pincode') }}"
                                                class="form-control" id="pincode" placeholder="Enter Pincode" required>
                                            @error('pincode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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
                                            <label for="gstin">GSTIN</label>
                                            <input type="text" name="gstin" value="{{ old('gstin') }}"
                                                class="form-control" id="gstin" placeholder="Customer's GSTIN" required>
                                            @error('gstin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pos">Place of Supply</label>
                                            <input type="text" name="pos" value="{{ old('pos') }}" class="form-control"
                                                id="pos" placeholder="Enter Place of Supply" required>
                                            @error('pos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-2">
                                    <div class="col-md-12">
                                        <strong>Referred By</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reference_code">Reference Code (Optional)</label>
                                            <input type="text" name="reference_code" value="{{ old('reference_code') }}"
                                                class="form-control" id="reference_code"
                                                placeholder="Enter reference code of the customer referred by">
                                            @error('reference_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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
                                            <label for="package_id">Select Package</label>
                                            <select name="package_id" class="form-control" id="package_id" required>
                                                <option value="">--Select Package--</option>
                                                @foreach($packages as $package)
                                                <option value="{{ $package->id }}">{{ $package->title }}
                                                    ( ₹{{ $package->price }} )</option>
                                                @endforeach
                                            </select>
                                            @error('package_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_type">Payment Type</label>
                                            <select name="payment_type" class="form-control" id="payment_type" required>
                                                <option value="">--Select Payment Type--</option>
                                                <option value="1">Payment Gateway</option>
                                                <option value="0">Cash</option>
                                            </select>
                                            @error('payment_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-6 pt-2">
                            <input type="submit" name="txt" class="btn btn-primary">
                            <a href="{{ route('customer.index') }}" class="btn btn-warning">Back</a>
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
