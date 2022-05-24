@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}"" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}"" rel=" stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="row">
                        <div class="col-md-8">
                            <h5>Customer Related Task Log</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('tasks.index') }}">Manage Tasks</a></li>
                                    <li class="active mb-2"><a href="#">Task Log</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <b>Name:</b>
                            {{ $customer->name }} <br>
                            <b>Name:</b>
                            {{ $customer->email }}
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="width-100 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Task Description</th>
                                            <th>Assigned Employee</th>
                                            <th>Start Date</th>
                                            <th>End date</th>
                                            <th>Status</th>
                                            <th>Alloted Date</th>
                                            <th>Completion Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customer->customerRelatedTasks as $task)
                                        <tr>
                                            <th>{{ $task->task->title }}</th>
                                            <th>{{ $task->task->description }}</th>
                                            <th>{{ $task->employee->name }}</th>
                                            <th>{{ $task->start_date }}</th>
                                            <th>{{ $task->end_date }}</th>
                                            @php
                                            if($task->status == 1){
                                            $status = '<span class="shadow-none badge badge-success">Completed</span>';
                                            }else{
                                            $status = '<span class="shadow-none badge badge-danger">Pending</span>';
                                            }
                                            @endphp
                                            <th>{!! $status !!}</th>
                                            <th>{{ $task->created_at }}</th>
                                            <th>{{ $task->completion_time ? $task->completion_time : "N/A"}}</th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
