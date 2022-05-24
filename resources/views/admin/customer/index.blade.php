@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endsection

@section('content')
<div id="content" class="main-content p-5" style="margin-top:1000px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing ml-4" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Customer Users</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="active mb-2"><a href="#">Manage Customers</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 ml-2">
                        <div class="col-md-6">
                            <a href="{{ route('customer.create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6><strong>Show/Hide Columns</strong></h6>
                        </div>
                        <div class="col-md-12">
                            <div class="toggle-list">
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="1">Name</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="2">Shop Name</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="3">Email</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="4">Phone Number</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="5">Superior</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="6">Employee</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="7">Package</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="8">Payment
                                    Method</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="9">Payment
                                    Status</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="10">Verification</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="11">Created At</a>
                                <a class="btn btn-success btn-sm toggle-vis mb-4 ml-2" data-column="12">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-3 table-responsive">

                        <table id="show-hide-col" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Superior</th>
                                    <th>Employee</th>
                                    <th>Package</th>
                                    <th>Payment Method</th>
                                    <th>Payment</th>
                                    <th>Verification</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Superior</th>
                                    <th>Employee</th>
                                    <th>Package</th>
                                    <th>Payment Method</th>
                                    <th>Payment</th>
                                    <th>Verification</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--  END CONTENT AREA  -->

@endsection

@section('scripts')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


<script>
    var table = $('#show-hide-col').DataTable({
        stateSave: true,
        responsive: true,
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
        "lengthMenu": [10, 20, 50],
        "order": [
            [10, "desc"]
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('customer.index') }}",
        },
        columns: [{
            "data": 'DT_RowIndex',
            orderable: false,
            searchable: false
        }, {
            data: 'name',
        }, {
            data: 'store_name',
            name: 'customer_details.store_name'
        }, {
            data: 'email',
        }, {data: 'number', name: 'number'},
         {
            data: 'superior',
        }, {
            data: 'employee',
        }, {
            data: 'package',
        }, {
            data: 'payment_method',
        }, {
            data: 'payment_status',
        }, {
            data: 'verification',
        }, {
            data: 'created_at',
            render: function (data, type, full, meta) {
                return data;
            }
        }, {
            data: 'action',
            orderable: false
        }]

    });

    $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();
        var column = table.column($(this).attr('data-column'));
        column.visible(!column.visible());
        if (column.visible()) {
            $(this).addClass("btn-success").removeClass("btn-warning");
        } else {
            $(this).addClass("btn-warning").removeClass("btn-success");
        }
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
