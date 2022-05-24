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
<div id="content" class="main-content" style="margin-top:400px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>All Assigned Tasks</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    <li class="active mb-2"><a href="#">All Assigned Tasks</a></li>
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
                                    <th>Employee</th>
                                    <th>Assignee</th>
                                    <th>Task</th>
                                    <th>Task Description</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th>Completion</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Customer</th>
                                    <th>Shop</th>
                                    <th>Employee</th>
                                    <th>Assignee</th>
                                    <th>Task</th>
                                    <th>Task Description</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th>Completion</th>
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



<!--  END CONTENT AREA  -->

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
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
                [9, "desc"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('all-tasks') }}",
            },
            columns: [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'customer',
                name: 'customer.name'
            }, {
                data: 'store_name',
                name: 'store_name'
            }, {
                data: 'employee',
                name: 'employee.name'
            }, {
                data: 'assignee',
                name: 'assignee.name'
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
                data: 'completion_time',
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
