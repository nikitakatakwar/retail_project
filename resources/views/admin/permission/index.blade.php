@extends('admin.layout.default')

@section('title')
{{ $page_title }}
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- <style>
    .mr-5, .mx-5 {
    margin-right: 5rem!important;
}
</style> -->



@endsection

@section('content')

                    <div class="row">
                        <div class="col-md-8">
                            <h5>Roles</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="breadcrumb-five pull-right mt-5 mr-5">
                                <ul class="breadcrumb">
                                    <li class="mb-2"><a href="{{ route('home') }}">Home</a>
                                    </li>&nbsp;&nbsp;&nbsp;
                                    <li class="active mb-2"><a href="#">Manage Permissions</a></li>&nbsp;&nbsp;&nbsp;
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
                    <div class="row mt-5">


                        <div class="col-md-6 offset-md-4">
                        <a href="{{ route('permission.create') }}" class="btn btn-primary mb-5">Add New</a>
                        <table class="table table-bordered yajra-datatable mt-5">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>created_at</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>



<!--  END CONTENT AREA  -->



@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('permission.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},

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




  });


</script>
@endsection

