@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">


    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">


@endsection

@section('content')

                    <div class="row offset-md-3 mt-5">
                        <div class="col-md-8">
                           <h5 class="ml-5 mt-5">Create Role</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right mt-5 mr-2">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="active mb-2"><a href="#">Manage Roles</a></li>&nbsp;&nbsp;
                                    <li class="active mb-2"><a href="#">Create Role</a></li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="float-right">
                                    Logout
                                    </a>
                                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                        <form method="POST" action="{{ route('role.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" id="name" placeholder="Enter Role Title" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Assign Permissions</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach ($available_permissions as $permission)
                                            <div class="col-md-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="permissions[]" id="permission-{{ $permission->id }}"
                                                        value="{{ $permission->id }}">
                                                    <label class="custom-control-label"
                                                        for="permission-{{ $permission->id }}">
                                                        <strong>{{ ucwords($permission->name) }}</strong> </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pt-2">
                                        <input type="submit" name="txt" class="btn btn-primary">
                                        <a href="{{ route('role.index') }}" class="btn btn-warning">Back</a>
                                    </div>
                                </div>

                            </form>
                       </div>
                    </div>



<!--  END CONTENT AREA  -->






