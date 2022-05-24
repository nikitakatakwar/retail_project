@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection



@section('content')


                    <div class="row mt-5" style="margin-top:400px!important;">
                        <div class="col-md-8 mt=5">
                            <h5>Edit Role</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('role.index') }}">Manage Role</a></li>
                                    <li class="active mb-2"><a href="#">Edit Role</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('role.update',$role->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" name="name"
                                                value="{{ old('name') ? old('name') : $role->name }}"
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
                                                        value="{{ $permission->id }}"
                                                        {{ in_array($permission->id,$role_permissions) ? "checked" : "" }}>
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



<!--  END CONTENT AREA  -->

@endsection
