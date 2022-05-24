@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:300px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Create Employee User</h5>
                        </div>
                        <div class="col-md-6 bg-light p-3">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('employee.index') }}">Manage Employees</a></li>
                                    <li class="active mb-2"><a href="#">Create Employee Users</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('employee.store') }}">
                                @csrf
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
                                            <label for="employee_id">Employee ID</label>
                                            <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                                                class="form-control" id="employee_id"
                                                placeholder="Enter Unique Employee ID" required>
                                            @error('employee_id')
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
                                    @can('assign role')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Select Role</label>
                                            <select class="form-control" name="role" id="role">
                                                <option value="">--Select Role--</option>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"> {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endcan
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 pt-2">
                                        <input type="submit" name="txt" class="btn btn-primary">
                                        <a href="{{ route('admin.index') }}" class="btn btn-warning">Back</a>
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
