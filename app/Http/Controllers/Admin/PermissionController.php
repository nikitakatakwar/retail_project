<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page_title  = "Manage Permissions";

        if ($request->ajax()) {
            $data =  Permission::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ( Permission $permission){
                    $actionBtn = '

                    <a href="permission/destroy/'.$permission->id.'
                    " class="btn btn-danger btn-sm" title="Hapus User" onclick="deleteRecord" id="button"><i class="fa fa-trash "></i></a>';
                    return $actionBtn;

                  })

                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })

                ->setRowClass('{{ $id % 2 == 0 ? "alert-success" : "alert-danger" }}')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permission.index')->with(compact('page_title', 'permissions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Create Permissions";
        return view('admin.permission.create')->with(compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:permissions,name'],
        ]);

        $permission       = new Permission();
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('permission.index')->with('success-message', 'Permission Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Permission::findOrFail($id);
        $data->delete();
        return redirect()->route('permission.index')->with('success-message', 'Permission Deleted Successfully!');
    }
}
