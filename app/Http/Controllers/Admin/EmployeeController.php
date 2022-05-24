<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssignedCustomer;
use App\DueDate;
use App\EmployeeHistory;
use App\Target;
use App\User;
use App\employee_detail;
use App\phone_number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class EmployeeController extends Controller
{

    public function __construct($page_title = null)
    {

        $this->page_title = "Manage Employee Users";

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
            $roles= User::join('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->join('Phone_numbers', 'Phone_numbers.user_id', '=', 'users.id')
            ->get(['users.*', 'employee_details.employee_id','employee_details.superior_id','phone_numbers.number']);

            $roles = $roles->transform(function ($item) {
            $item->role = $item->roles->pluck('name')->implode(', ');
            return $item;
            })->all();

            //   dd($roles);

            if ($request->ajax()) {
                // $data = User::select('*');
                return Datatables::of($roles)
                        ->addIndexColumn()
                        ->addColumn('action', function ($data) {
                            $button = '<a href="' . route('employee.edit', $data->id) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('employee.destroy', $data->id) . '">';
                            $button .= '<input type="hidden" name="_method" value="DELETE">';
                            $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                            if (Auth::user()->hasPermissionTo('delete employee')) {
                                $button .= '<a href="#" onClick="deleteItem(' . $data->id . ');" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';
                            }

                            if (Auth::user()->hasPermissionTo('assign customers')) {
                                $button .= '<a href="' . route('employee.customers', $data->id) . '">
                                <svg style="height:20px;margin-left:8px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> </a>';
                            }

                            $button .= '</form>';
                            return $button;
                        })
                        ->addColumn('superior', function (User $user) {
                            return $user->employee_detail ? ($user->employee_detail->superior ? $user->employee_detail->superior->name : "N/A") : "N/A";
                        })
                        ->addColumn('checkbox', function ($data) {
                            $html = '
                            <input type="checkbox" value=' . $data->id . ' class="selected-employee" >';
                            return $html;
                        })
                        ->addColumn('customer_target' , function($data){


                            if(!$data->target){
                                $buttons = "";
                                $buttons = '<button class="btn btn-info btn-sm action_button"  style="color: white;">No Targets</button>&nbsp;';
                             return $buttons;

                            }

                            if($data->target){

                                    $button = "<button type='button' class='btn btn-sm btn-warning' onclick='showTarget($data->id)'> Target Info </button>";

                                    return $button;
                             }

                            })
                            ->editColumn('created_at', function ($user) {
                                return [
                                    'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                                    'timestamp' => $user->created_at->timestamp
                                ];
                            })
                        ->rawColumns(['action', 'verification', 'checkbox', 'customer_target'])
                        ->make(true);
            }


//   dd($roles);

        $page_title = $this->page_title;
        return view('admin.employee.index')->with(compact('page_title'));
    }


     public function showEmployeeCustomers($id)
    {
        $page_title = $this->page_title;

        if (request()->ajax()) {
            $query = User::role('customer')
                ->with('employee', 'phone_number')
                ->whereHas('customers')
                ->doesntHave('moving_status')
                ->with(['customer_details' => function ($query) {
                    $query->with('package');
                }])
                ->selectRaw('distinct users.*');

            return DataTables::of($query)
                ->addColumn('action', function ($data) use ($id) {
                    $button = "";
                    $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('employee.customers.add', $id) . '">';
                    $button .= '<input type="hidden" name="employee_id" value="' . $id . '">';
                    $button .= '<input type="hidden" name="customer_id" value="' . $data->id . '">';
                    $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    $button .= "<button type='submit' class='btn btn-sm btn-info mr-1 mb-1'> Assign </button> </form>";
                    return $button;
                })
                ->addColumn('phone_number', function ($data) {
                    return $data->phone_number->number;
                })
                ->addColumn('payment_method', function ($data) {
                    if (count($data->transactions) > 0) {
                        $payment_types = array('Cash', 'Payment Gateway', 'UPI', 'Internet Banking', 'Paytm', 'Commission Basis');
                        return $payment_types[$data->transactions()->first()->payment_type];
                    } else {
                        return "N/A";
                    }

                })
                ->addColumn('store_name', function ($data) {
                    return $data->customer_details ? $data->customer_details->store_name : "N/A";
                })
                ->addColumn('phone_number', function ($data) {
                    return $data->phone_number->number;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('payment_status', function ($data) {
                    $html = '';
                    if ($data->customers->payment_status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->customers->payment_status == 1) {
                        $html .= '<span class="shadow-none badge badge-success">Paid</span>';
                    }
                    return $html;
                })
                ->addColumn('move_status', function ($data) {
                    $html = '';
                    if (!$data->moving_status || $data->moving_status->move_status == 1) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->moving_status && $data->moving_status->move_status == 0) {
                        $html .= '<span class="shadow-none badge badge-info">Moved</span>';
                    }
                    return $html;
                })
                ->addColumn('employee', function (User $user) {
                    return $user->employees ? $user->employees->map(function ($employee) {
                        return $employee->name;
                    })->implode(',') : "N/A";
                })
                ->filterColumn('employee', function ($query, $keyword) {
                    $query->whereHas('employees', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                })
                ->addColumn('package', function ($data) {
                    return $data->customer_details->package->title . " (Rs. " . $data->customer_details->package->price . ")";
                })
                ->addColumn('superior', function ($data) {
                    return $data->employees ? $data->employees->map(function ($employee) {
                        return $employee->employee_detail ? ($employee->employee_detail->superior ? $employee->employee_detail->superior->name : "N/A") : "N/A";
                    })->implode(',') : "N/A";
                })
                ->filterColumn('superior', function ($query, $keyword) {
                    $query->whereHas('employees', function ($query) use ($keyword) {
                        $query->whereHas('employee_detail', function ($query) use ($keyword) {
                            $query->whereHas('superior', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%" . $keyword . "%");
                            });
                        });
                    });
                })
                ->addColumn('employee', function (User $user) {
                    return $user->employees ? $user->employees->map(function ($employee) {
                        return $employee->name;
                    })->implode(',') : "N/A";
                })
                ->filterColumn('employee', function ($query, $keyword) {
                    $query->whereHas('employees', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'move_status'])
                ->make(true);
        }

        return view('admin.employee.customers')->with(compact('page_title', 'id'));
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

        return view('admin.employee.create')->with(compact('page_title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'password'     => 'required|confirmed',
            'employee_id'  => 'required',
        ]);

        $user           = new User;
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

         $employee_detail= new employee_detail;

         $employee_detail->employee_id =$request->input('employee_id');
         $employee_detail->superior_id =  Auth::user()->id;
         $user->employee_detail()->save($employee_detail);


        $phone_data = [ 'number' => $request->input('phone_number')];
        $user->phone_number()->create($phone_data);



        if ($request->input('role')) {
            $user->assignRole($request->input('role'));
        } else {
            $user->assignRole('employee');
        }


            return redirect()->route('employee.index')->with('success-message', 'Employee User Saved Successfully!');
    }


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
        $user       = User::where('id', $id)->with('phone_number')->first();
        $page_title = $this->page_title;
        $roles      = Role::all();
        $superiors  = User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['customer']);
        })->get();
        $user_superior = $user->employee_detail ? ($user->employee_detail->superior ? $user->employee_detail->superior->id : null) : null;
        return view('admin.employee.edit')->with(compact('page_title', 'user', 'roles', 'superiors', 'user_superior'));
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
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email,' . $id,
            'password'     => 'confirmed',
            'phone_number' => 'required',
            'employee_id'  => 'required|unique:employee_details,employee_id,' . $id . ',user_id',
        ]);

        $user        = User::find($id);
        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        if ($request->password) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->update();

        $user_superior = $user->employee_detail ? ($user->employee_detail->superior ? $user->employee_detail->superior->id : null) : null;

        // echo $request->input('superior');exit; //253

        if ($request->input('due_date')) {
            $due_date =  DueDate::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'user_id' => $user->id,
                'due'     => $request->input('due_date'),
            ]);
        }


        Phone_number::updateOrInsert(
            [
                'user_id' => $user->id,
            ],
            [
                'user_id' => $user->id,

                'number'  => $request->input('phone_number'),
            ]
        );

        Employee_detail::updateOrInsert(
            [
                'user_id' => $user->id,
            ],
            [
                'user_id'     => $user->id,
                'employee_id' => $request->input('employee_id'),
            ]
        );

        if ($request->input('role')) {
            $user->syncRoles($request->input('role'));
        } else {
            $user->syncRoles('employee');
        }

        return redirect()->route('employee.index')->with('success-message', 'Employee User Updated Successfully!');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */







    public function submitTarget(Request $request)
    {
        $this->validate($request, [
            'target'           => 'required|numeric',
            'target_date_from' => 'required|date',
            'target_date'      => 'required|date',
            'green_value'      => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->input(['selected_employee']) as $employee) {
            Target::updateOrCreate(
                [
                    'user_id' => $employee,
                ],
                [
                    'user_id'          => $employee,
                    'target'           => $request->input('target'),
                    'target_date_from' => $request->input('target_date_from'),
                    'target_date'      => $request->input('target_date'),
                    'green_value'      => $request->input('green_value'),
                ]
            );

         }
        return redirect()->back()->with('success-message', 'Target Set Successfully!');
    }

    public function showTarget(Request $request)
    {
        $employee_id = $request->get('employee_id');
        $employee    = User::find($employee_id);
        if (!($employee && $employee->target)) {
            return ['error' => 'Target Not Found!'];
        }

        $target_details                     = array();
        $target_details['employee_name']    = $employee->name;
        $target_details['target_points']    = $employee->target->target;
        $target_details['target_date']      = $employee->target->target_date;
        $target_details['target_from_date'] = $employee->target->target_date_from;
        $target_details['green_value']      = $employee->target->green_value;

        // target from date <= registration date <= target date
        return response()->json($target_details);

    }

    public function addEmployeeCustomers(Request $request)
    {
        $assigned_customer              = new AssignedCustomer();
        $assigned_customer->customer_id = $request->input('customer_id');
        $assigned_customer->employee_id = $request->input('employee_id');
        $assigned_customer->move_status = 1;

        $assigned_customer->save();
        return redirect()->back()->with('success-message', 'Customer Assigned to Employee Successfully!');
    }


    public function moveCustomers()
    {
        $page_title = $this->page_title;

        if (request()->ajax()) {
            $query = User::role('customer')
                ->with('employees', 'phone_number')
                ->whereHas('customer_details')
                ->when(Auth::user()->hasPermissionTo('show move customer') && count(array_intersect(['customer', 'admin'], Auth::user()->getRoleNames()->toArray())) == 0, function ($query) {
                    $query->whereHas('moving_status', function ($query) {
                        $query->where('employee_id', Auth::user()->id);
                    });
                })
                ->with(['customer_details' => function ($query) {
                    $query->with('package');
                }])
                ->selectRaw('distinct users.*');

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $button = '';
                    $button .= "<a href=" . route('customer.show', $data->id) . " class='btn btn-sm btn-info mr-1 mb-1'> View </a>";
                    return $button;
                })
                ->addColumn('phone_number', function ($data) {
                    return $data->phone_number->number;
                })
                ->addColumn('payment_method', function ($data) {
                    if (count($data->transactions) > 0) {
                        $payment_types = array('Cash', 'Payment Gateway', 'UPI', 'Internet Banking', 'Paytm', 'Commission Basis');
                        return $payment_types[$data->transactions()->first()->payment_type];
                    } else {
                        return "N/A";
                    }

                })
                ->addColumn('store_name', function ($data) {
                    return $data->customer_details ? $data->customer_details->store_name : "N/A";
                })
                ->addColumn('phone_number', function ($data) {
                    return $data->phone_number->number;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('payment_status', function ($data) {
                    $html = '';
                    if ($data->customer_details->payment_status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->customer_details->payment_status == 1) {
                        $html .= '<span class="shadow-none badge badge-success">Paid</span>';
                    }
                    return $html;
                })
                ->addColumn('move_status', function ($data) {
                    $html = '';
                    if (!$data->moving_status || $data->moving_status->move_status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->moving_status && $data->moving_status->move_status == 1) {
                        $html .= '<span class="shadow-none badge badge-info">Moved</span>';
                    }
                    return $html;
                })
                ->addColumn('employee', function (User $user) {
                    return $user->employees ? $user->employees->map(function ($employee) {
                        return $employee->name;
                    })->implode(',') : "N/A";
                })
                ->filterColumn('employee', function ($query, $keyword) {
                    $query->whereHas('employees', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                })
                ->addColumn('package', function ($data) {
                    return $data->customer_details->package->title . " (Rs. " . $data->customer_details->package->price . ")";
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'move_status'])
                ->make(true);
        }

        return view('admin.employee.assigned_customers')->with(compact('page_title'));
    }







}
