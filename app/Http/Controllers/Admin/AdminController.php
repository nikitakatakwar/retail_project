<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * Class constructor.
     */
    public function __construct($page_title = null)
    {
        $this->page_title = "Manage Admin Users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {

        $page_title = $this->page_title;

                    $adminUsers = User::whereHas('roles', function($q)
                                        {
                                        $q->where('name', 'admin');
                                        })->get();

                    if (request()->ajax()) {
                        return DataTables::of($adminUsers)
                        ->addIndexColumn()

                            ->addColumn('action', function ($data){
                                $actionBtn = '<a href="admin/edit/'.$data->id.'" title="Edit User" class="btn btn-sm" style="color: #fff;background-color: #3DCB3A;border-color: #8ad3d3"> <i class="fa fa-edit"></i> </a>

                                <a href="admin/destroy/'.$data->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-trash "></i></a>';
                                return $actionBtn;
                            })


                        ->editColumn('created_at', function ($user) {
                            return [
                                'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                                'timestamp' => $user->created_at->timestamp
                            ];
                        })


                        ->make(true);


                    }
            return view('admin.admin.index')->with(compact('page_title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = $this->page_title;
        $roles      = Role::all();
        return view('admin.admin.create')->with(compact('page_title', 'roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new User;
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->password = Hash::make($request->input('password'));
        $student->save();

        if ($request->input('role')) {
            $student->assignRole($request->input('role'));
        } else {
            $student->assignRole('admin');
        }

       return redirect()->route('admin.index')->with('success-message', 'Admin Saved Successfully!');
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
        $user       = User::find($id);
        $page_title = $this->page_title;
        $roles      = Role::all();
        return view('admin.admin.edit')->with(compact('page_title', 'user', 'roles'));
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
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'confirmed',
        ]);

        $user        = User::find($id);
        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        if ($request->password) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->update();

        if ($request->input('role')) {
            $user->syncRoles($request->input('role'));
        } else {
            $user->syncRoles('employee');
        }

        return redirect()->route('admin.index')->with('success-message', 'Admin Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.index')->with('success-message', 'Admin User Deleted Successfully!');
    }
}
