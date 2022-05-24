@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
@endsection

@section('style')

<link href="{{ asset('admin_assets/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin_assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/plugins/table/datatable/datatables.css') }}">
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
                            <h5>Customer Reference Records</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="active mb-2"><a href="#">Manage Reference Records</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <h6><strong>Name:</strong> {{ $customer->name }}</h6>
                            @forelse ($customer->accounts as $account)
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <b>Account : </b>{{ $account->type }} <br>
                                        <b>Account No : </b>{{ $account->number }} <br>
                                        <b>Description : </b>{{ $account->description }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="jumbotron">
                                <h3 class="text-center">No Accounts Added Yet!</h3>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="table-responsive mb-2 mt-3">
                        <table id="zero-config" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Points</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Transaction Number</th>
                                    <th>Transaction Type</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customer->reference_points as $key => $point)
                                <tr>
                                    <td>
                                        {{ $point->points }}
                                    </td>
                                    <td>
                                        {{ $point->description }}
                                    </td>
                                    <td>
                                        @if ($point->status == 0)
                                        <span class="badge badge-danger">Pending</span>
                                        @elseif($point->status == 1)
                                        <span class="badge badge-success">Deposited</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!in_array($role->name,$main_roles))
                                        <a href="{{ route('role.edit',$role->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger">Delete Role</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <h4 class="text-center">No Reference Records Found!</h4>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Points</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Transaction Number</th>
                                    <th>Transaction Type</th>
                                    <th>Created At</th>
                                </tr>
                            </tfoot>
                        </table>
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
<script src="{{ asset('admin_assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/app.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/plugins/table/datatable/dt-global_style.css') }}">
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{ asset('admin_assets/plugins/table/datatable/datatables.js') }}"></script>
<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],

        "lengthMenu": [10, 20, 50],
        "order": [
            [4, "desc"]
        ],
        processing: true,
        serverSide: false,

    });

</script>

<script>
    function deleteItem(id) {
        if (confirm('Are you sure to delete?')) {
            $("#frmDelete_" + id).submit();
        } else {
            return false;
        }
    }

</script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@endsection
