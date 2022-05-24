@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}"" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}"" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:600px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Edit Employee User</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('employee.index') }}">Manage Employees</a></li>
                                    <li class="active mb-2"><a href="#">Edit Employee Users</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('employee.update',$user->id) }}" autocomplete="off">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Full Name</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
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
                                            <input type="text" name="employee_id"
                                                value="{{ $user->employee_detail->employee_id }}" class="form-control"
                                                id="employee_id" placeholder="Enter Unique Employee ID"
                                                autocomplete="off" required>
                                            @error('employee_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="text" name="email" value="{{ $user->email }}"
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
                                            <label for="">Phone Number</label>
                                            <input type="text" name="phone_number"
                                                value="{{ $user->phone_numbers['number'] }}" class="form-control"
                                                id="phone_number" placeholder="Enter Phone Number" required>
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Enter Password" autocomplete="chrome-off">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Enter Password again">
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
                                                <option {{ $user->roles->first()->id == $role->id ? "selected" : "" }}
                                                    value="{{ $role->id }}"> {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endcan
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Due Date</label>
                                            <input type="date" class="form-control" id="due_date" name="due_date"
                                                placeholder="Enter Due Date"
                                                value="{{ $user->due_date ? $user->due_date->due: "" }}">
                                            @error('due_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                @can('assign superior')
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5><strong>Transfer Employee</strong></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="superior">Select Superior</label>
                                            <select class="form-control" name="superior" id="superior">
                                                <option value="">--Select Superior--</option>
                                                @foreach ($superiors as $superior)
                                                <option {{ $user_superior == $superior->id ? "selected" : ""   }}
                                                    value="{{ $superior->id }}">{{ $superior->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Transfer Date</label>
                                            <input type="date" class="form-control" id="transfer_date"
                                                name="transfer_date" placeholder="Enter Transfer Date"
                                                value="{{ $user->employee_histories && $user->employee_histories->first() ? $user->employee_histories->first()->transfer_date: "" }}">
                                            @error('transfer_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @endcan

                                <div class="row mt-4">
                                    <div class="col-md-6 pt-2">
                                        <input type="submit" name="txt" class="btn btn-primary">
                                        <a href="{{ route('employee.index') }}" class="btn btn-warning">Back</a>
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
