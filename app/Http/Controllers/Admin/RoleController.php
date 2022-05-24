<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Http\Controllers\Controller;
use App\Rules\MinimumOneInArray;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB ;
use RealRashid\SweetAlert\Facades\Alert;

use Yajra\Datatables\Datatables;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page_title = "Manage Roles";
        $main_roles = [];

        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function (Role $role){
                    $actionBtn = '<a href="'.route('role.edit',$role->id).'" title="Edit User" class="btn btn-sm" style="color: #fff;background-color: #3DCB3A;border-color: #8ad3d3"> <i class="fa fa-edit"></i> </a>

                    <a href="role/destroy/'.$role->id.'" class="btn btn-danger btn-sm" title="Hapus User" onclick="deleteRecord" id="button"><i class="fa fa-trash "></i></a>';
                    return $actionBtn;


                  })


                ->editColumn('name', function ($item) {
                return '<a href="' . route('role.edit',$item->id) . '">'.$item->name.'</a>';
            })

               ->rawColumns(['action','name'])
             ->make(true);
        }

                    return view('admin.role.index')->with(compact('page_title'));
        }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $available_permissions = Permission::all();
        $page_title            = "Create Roles";

        return view('admin.role.create')->with(compact('page_title', 'available_permissions'));
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
            'name'        => ['required'],
            'permissions' => ['required'],
        ]);

        $role       = new Role();
        $role->name = $request->input('name');
        $role->save();

        $role->givePermissionTo($request->input('permissions'));


        return redirect()->route('role.index')->with('message', 'Role Created Successfully!');
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
        $available_permissions = Permission::all();
        $page_title            = "Edit Role";
        $role                  = Role::where('id', $id)->with('permissions')->first();

        $role_permissions = $role->permissions()->allRelatedIds()->toArray();
        return view('admin.role.edit')->with(compact('page_title', 'available_permissions', 'role', 'role_permissions'));
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
        $validatedData = $request->validate([
            'name'        => ['required'],
            'permissions' => ['required', 'array'],
        ]);

        $role       = Role::find($id);
        $role->name = $request->input('name');
        $role->update();

        $role->permissions()->sync($request->input('permissions'));



        return redirect()->route('role.index')->with('success-message', 'Role Created Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

        // public function destroy($id)
        // {
        //     $role = Role::where('id', $id)->withCount('users')->first();
        //     if ($role->users_count > 0) {
        //         return redirect()->route('role.index')->with('error-message', $role->users_count . ' users are attached to this role, Please delete the attached users first!');
        //     }
        //     $role->delete();
        //     return redirect()->route('role.index')->with('success-message', 'Role Deleted Successfully!');
        // }








        public function destroy($id)
        {   $data = Role::findOrFail($id);
            $data->delete();

        return redirect()->route('role.index')->with('success-message', 'Role Deleted Successfully!');
        }
}
