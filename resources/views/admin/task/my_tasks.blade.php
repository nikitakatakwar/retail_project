@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
@endsection

@section('style')

<link href="{{ asset('admin_assets/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin_assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/plugins/table/datatable/datatables.css') }}">
<link href="{{ asset('admin_assets/css/elements/miscellaneous.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/breadcrumb.css') }}" rel=" stylesheet" type="text/css" />
<link href="{{ asset('admin_assets/css/elements/color_library.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>My Tasks</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    <li class="active mb-2"><a href="#">My Tasks</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-3 table-responsive">

                        <table id="show-hide-col" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Customer</th>
                                    <th>Shop</th>
                                    <th>Assignee</th>
                                    <th>Task</th>
                                    <th>Task Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Customer</th>
                                    <th>Shop</th>
                                    <th>Assignee</th>
                                    <th>Task</th>
                                    <th>Task Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
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
    $(document).ready(function () {
        var c1 = $('#show-hide-col').DataTable({
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
                [7, "desc"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('my-tasks') }}",
            },
            columns: [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'customer',
                name: 'customer'
            }, {
                data: 'store_name',
                name: 'store_name'
            }, {
                data: 'assignee',
                name: 'assignee'
            }, {
                data: 'title',
                name: 'task.title'
            }, {
                data: 'description',
                name: 'task.description'
            }, {
                data: 'start_date',
            }, {
                data: 'end_date',
            }, {
                data: 'status',
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

        $("#multi-select").click(function () {
            $('.selected-customer').each(function () {
                this.click();
            });
        });

        $("#target-btn").on('click', function () {
            var yourArray = [];
            var html = '';
            if ($(".selected-customer:checked").length < 1) {
                alert("Please select Customer First!");
                return false;
            }
            $(".selected-customer:checked").each(function (i) {
                html += '<input type="hidden" name="selected_customer[' + i + ']" value="' + $(
                        this)
                    .val() +
                    '">'
            });
            $("#selected-customers-div").html(html);
            $("#exampleModal").modal('show');
        });
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
