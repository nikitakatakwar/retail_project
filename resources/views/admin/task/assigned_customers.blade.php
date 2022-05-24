@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<div id="content" class="main-content" style="margin-top:600px;">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Moved Customer Users</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('employee.index') }}">Tasks</a>
                                    </li>
                                    <li class="active mb-2"><a href="#">Assign Customers</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">


                            <button type="button" class="btn btn-primary" id="target-btn">
                                Add Task
                            </button>

                        </div>
                    </div>

                    <div class="mb-2 mt-3 table-responsive">

                        <table id="show-hide-col" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th> <input type="checkbox" value=' . $data->id . ' id="multi-select"> </th>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Shop Name</th>
                                    <th>Phone Number</th>
                                    <th>Moving Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Shop Name</th>
                                    <th>Phone Number</th>
                                    <th>Moving Status</th>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                </div>
                <div class="modal-body">
                    <form id="target-form" action="{{ route('assign-tasks.submit') }}" method="POST">
                        @csrf
                        <div id="selected-customers-div"></div>

                        <div class="form-group">
                            <label for="name">Select Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                <option value="">--Select Employee--</option>
                                @foreach ($employees as $employee)
                                <option {{ old('employee_id') == $employee->id ? "selected" : ""  }}
                                    value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Select Task</label>
                            <select name="task_id" id="task_id" class="form-control">
                                <option value="">--Select Task--</option>
                                @foreach ($tasks as $task)
                                <option {{ old('task_id') == $task->id ? "selected" : ""  }} value="{{ $task->id }}">
                                    {{ $task->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control"
                                id="start_date" placeholder="ENTER START DATE FROM" required>
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control"
                                id="end_date" placeholder="ENTER END DATE" required>
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="target_value">Target</label>
                            <input type="number" name="target_value" value="{{ old('target_value') }}"
                        class="form-control" id="target_value" placeholder="Enter Target" required>
                        @error('target_value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="button" class="btn btn-primary" onclick="$('#target-form').submit();">Save</button>
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
                [6, "desc"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('assign-tasks') }}",
            },
            columns: [{
                "data": "checkbox",
                orderable: false,
                searchable: false
            }, {
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
            }, {
                data: 'store_name',
                name: 'customer_details.store_name'
            }, {
                data: 'phone_number',
                name: 'phone_number.number'
            }, {
                data: 'move_status',
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
