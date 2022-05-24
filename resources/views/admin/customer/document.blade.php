@extends('admin.layout.default')



@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/tables/table-basic.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/plugins/lightbox/photoswipe.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/plugins/lightbox/default-skin/default-skin.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('admin_assets/plugins/lightbox/custom-photswipe.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content p-5">
                        <div class="layout-px-spacing">
                            <div class="row layout-top-spacing" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                    <div class="widget-content widget-content-area br-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Verification Documents and Images</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="breadcrumb-five pull-right">
                                                    <ul class="breadcrumb">
                                                        <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                                        </li>
                                                        <li class="mb-2"><a href="{{ route('customer.index') }}">Manage Customer</a></li>
                                                        <li class="active mb-2"><a href="#">Customer Documents</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                             <div id="demo-test-gallery" class="demo-gallery" data-pswp-uid="1">
                       

                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5><strong>Upload Documents Below</strong></h5>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                        <form method="POST" action="{{ route('customer.document.submit') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="document_category">Select Document Category</label>
                                        <select name="document_category" class="form-control" id="document_category"
                                            required>
                                            <option value="">--Select Document Type--</option>
                                            @foreach ($document_categories as $category)
                                            <option {{ old('document_category') == $category->title ? "selected" : "" }}
                                                value="{{ $category->title }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('document_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="document">Select Document</label>
                                    <div class="custom-file mb-4">
                                        <input name="document" type="file" class="custom-file-input" id="document"
                                            required>
                                        <label class="custom-file-label" for="document">Choose Document File</label>
                                        @error('document_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-12 pt-2">
                                    <button type="Submit" class="btn btn-primary">Submit </button>
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
                </div>

<!--  END CONTENT AREA  -->
@endsection

@section('scripts')
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('admin_assets/plugins/lightbox/photoswipe.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/lightbox/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/lightbox/custom-photswipe.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
@endsection
