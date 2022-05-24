
@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection


<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-8 col-lg-8 col-sm-8 offset-md-3  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="ml-5 mt-4">Tasks</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="active mb-2"><a href="#">create Employee</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <a href="{{ route('employee.create') }}" class="btn btn-primary mb-5">Add New</a>
                        &nbsp; &nbsp;

                        <button type="button" class="btn btn-primary mb-5" id="target-btn">
                            Add Target
                        </button>
                    </div>
                    <div class="table-responsive mb-2 mt-3 p-5">
                        <table class="table table-bordered yajra-datatable mt-5 display nowrap  display"  style="width:100%"  class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th> <input type="checkbox" value=' . $data->id . ' id="multi-select"> </th>
                                    <th>No</th>
                                    <th style="width: 20px !important">Name</th>
                                    <th>Roles</th>
                                    <th>Email</th>
                                    <th>Phone_number</th>
                                    {{-- <th>employee_id</th>
                                    <th>superior_id</th> --}}
                                    <th>Superior</th>
                                    <!-- <th>Customer Target</th> -->
                                    <th>Target Status</th>
                                    <th>created_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th> <input type="checkbox" value=' . $data->id . ' id="multi-select"> </th>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Roles</th>
                                    <th>Email</th>
                                    <th>Phone_number</th>
                                    {{-- <th>employee_id</th>
                                    <th>superior_id</th> --}}
                                    <th>Superior</th>
                                    <!-- <th>Customer Target</th> -->
                                    <th>Target Status</th>
                                    <th>created_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Target For Selected Employee</h5>
        </div>
        <div class="modal-body">
            <form id="target-form" action="{{ route('target.submit') }}" method="POST">
                @csrf
                <div id="selected-employee-div"></div>

                <div class="form-group">
                    <label for="name">Target</label>
                    <input type="number" name="target" value="{{ old('target') }}" class="form-control"
                        id="target" placeholder="Enter Target" required>
                    @error('target')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="target_date_from">Target Date</label>
                    <input type="date" name="target_date_from" value="{{ old('target_date_from') }}"
                        class="form-control" id="target_date_from" placeholder="ENTER TARGET DATE FROM"
                        required>
                    @error('target_date_from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="target_date">Target Date</label>
                    <input type="date" name="target_date" value="{{ old('target_date') }}" class="form-control"
                        id="target_date" placeholder="ENTER TARGET DATE" required>
                    @error('target_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="green_value">Green Value Percentage</label>
                    <input type="number" name="green_value" value="{{ old('green_value') }}"
                        class="form-control" id="green_value" placeholder="Enter Green Value" required>
                    @error('green_value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            <button type="button" class="btn btn-primary" onclick="$('#target-form').submit();">Save</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="targetDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Target Detail Information</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <strong>Employee Name : <span id="employee_name"></span></strong> <br>
                    <strong>Target : <span id="target_points"></span></strong> <br>
                    <strong>Target From : <span id="target_from"></span></strong> <br>
                    <strong>Target Date : <span id="target_date_date"></span></strong> <br>
                    <strong>Green Value : <span id="green_value_value"></span></strong> <br>
                    <strong>Target Completed : <span id="completed_target"></span></strong> <br>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            {{-- <button type="button" class="btn btn-primary" onclick="$('#target-form').submit();">Save</button> --}}
        </div>
    </div>
</div>
</div>
{{-- scroll cdn --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>



<script type="text/javascript">
    $('.yajra-datatable').DataTable({

         processing: true,
         serverSide: true,
         ajax: {
             url: "{{ route('employee.index') }}",
         },


        columns: [

{
            "data": "checkbox",
            orderable: false,
            searchable: false
        },
// {data: "checkbox", name:"checkbox"},
{data: 'DT_RowIndex', name: 'DT_RowIndex'},
{data: 'name', name: 'name' , width: '67px' },
{data: 'role', name: 'role'},
{data: 'email', name: 'email'},
{data: 'number', name: 'number'},
// {data: 'employee_id', name: 'employee_id'},
// {data: 'employee_id', name: 'employee_id'},
{data: 'superior', name: 'superior'},
{ data: 'customer_target'},


  {data: 'created_at', name: 'created_at.timestamp',
            data: {
                _: 'created_at.display',
                sort: 'created_at.timestamp'
            }},

{
    data: 'action',
    name: 'action',
    orderable: true,
    searchable: true
},


]

     });

 </script>



<script type="text/javascript">

// $(document).ready(function() {
//     $('.yajra-datatable').DataTable( {
//         "scrollX": true,
//         "destroy":true,
//         "autoWidth":true,


//     } );

// } );





//     var table = $('.yajra-datatable').DataTable({
//     processing: true,
//     serverSide: true,


//     columnDefs: [ {


//         checkboxes: {
//                'selectRow': true
//             }

//         } ],

//     select: {
//              style: 'multi'

//         },

//         responsive: true,
//        stripeClasses: [],
//        lengthMenu: [10, 20, 50, 100],
//         order: [[ 2, 'desc' ]],

//     ajax: "{{ route('employee.index') }}",
//     columns: [

//         {
//                     "data": "checkbox",
//                     orderable: false,
//                     searchable: false
//                 },
//         // {data: "checkbox", name:"checkbox"},
//         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
//         {data: 'name', name: 'name' , width: '67px' },
//         {data: 'role', name: 'role'},
//         {data: 'email', name: 'email'},
//         {data: 'number', name: 'number'},
//         // {data: 'employee_id', name: 'employee_id'},
//         // {data: 'employee_id', name: 'employee_id'},
//         {data: 'superior', name: 'superior'},
//         { data: 'customer_target'},


//           {data: 'created_at', name: 'created_at.timestamp',
//                     data: {
//                         _: 'created_at.display',
//                         sort: 'created_at.timestamp'
//                     }},

//         {
//             data: 'action',
//             name: 'action',
//             orderable: true,
//             searchable: true
//         },


//     ]


// });





        $("#multi-select").click(function () {
            $('.selected-employee').each(function () {
                this.click();
            });
        });


        $("#target-btn").on('click', function () {
            var yourArray = [];
            var html = '';
            if ($(".selected-employee:checked").length < 1) {
                alert("Please select Employee First!");
                return false;
            }
            $(".selected-employee:checked").each(function (i) {
                html += '<input type="hidden" name="selected_employee[' + i + ']" value="' + $(
                        this)
                    .val() +
                    '">'
            });
            $("#selected-employee-div").html(html);
            $("#exampleModal").modal('show');
        });




    </script>


<script>
    function showTarget(employee_id) {

        $.ajax({
            url: '{{ route("target.show") }}',
            type: 'GET',
            dataType: 'json',
            data: {
                format: 'json',
                employee_id: employee_id,
            },
            error: function () {
                $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                console.log(data);
                $("#employee_name").html(data.employee_name);
                $("#target_points").html(data.target_points);
                $("#target_from").html(data.target_from_date);
                $("#target_date_date").html(data.target_date);
                $("#green_value_value").html(data.green_value);
                $("#completed_target").html(data.target_completed + " (" + data.target_completed_percent +
                    "%)");

                $("#targetDetail").modal('show');
            }

        });


    }



</script>


{{--
<script src="{{ asset('admin_assets/plugins/table/datatable/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        c1 = $('.yajra-datatable').DataTable({
            stateSave: true,
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
            "responsive": true,
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50, 100],
            "order": [
                [2, "desc"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employee.index') }}",
            },
            columns: [{
                    "data": "checkbox",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },



                {data: 'name', name: 'name'},
                {data: 'role', name: 'role'},
                {data: 'email', name: 'email'},
                {data: 'number', name: 'number'},
                {data: 'employee_id', name: 'employee_id'},
                {data: 'employee_id', name: 'employee_id'},
                {data: 'superior', name: 'superior'},

                {data: 'created_at', name: 'created_at.timestamp',
                    data: {
                        _: 'created_at.display',
                        sort: 'created_at.timestamp'
                    }},

                {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
        },


            ]

        });

        $("#multi-select").click(function () {
            $('.selected-employee').each(function () {
                this.click();
            });
        });

        $("#target-btn").on('click', function () {
            var yourArray = [];
            var html = '';
            if ($(".selected-employee:checked").length < 1) {
                alert("Please select Employee First!");
                return false;
            }
            $(".selected-employee:checked").each(function (i) {
                html += '<input type="hidden" name="selected_employee[' + i + ']" value="' + $(
                        this)
                    .val() +
                    '">'
            });
            $("#selected-employee-div").html(html);
            $("#exampleModal").modal('show');
        });
    });

</script> --}}

