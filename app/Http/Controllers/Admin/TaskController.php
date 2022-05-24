<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssignedTask;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    public function __construct($page_title = null)
    {
        $this->page_title = "Manage Tasks";
    }

    public function index()
    {

        $page_title = $this->page_title;

        if (request()->ajax()) {
            return DataTables::of(Task::all())
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('tasks.edit', ['task' => $data->id]) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('tasks.destroy', ['task' => $data->id]) . '">';
                    $button .= '<input type="hidden" name="_method" value="DELETE">';
                    $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';

                    $button .= '<a href="#" onClick="deleteItem(' . $data->id . ');" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0  1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';

                    $button .= '</form>';
                    return $button;
                })
                ->addColumn('status', function ($data) {
                    $html = '';
                    if ($data->status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Inactive</span>';
                    } elseif ($data->status == 1) {
                        $html .= '<span class="shadow-none badge badge-info">Active</span>';
                    }
                    return $html;
                })
                ->addColumn('created_by', function ($data) {
                    return $data->created_by ? $data->created_by->name : "N/A";
                })

                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.task.index')->with(compact('page_title'));
    }


    public function create()
    {
        $page_title = $this->page_title;

        return view('admin.task.create')->with(compact('page_title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|max:255',
            'description' => 'required',
        ]);

        $task              = new Task();
        $task->title       = $request->input('title');
        $task->description = $request->input('description');
        $task->status      = 1;
        $task->user_id     = Auth::user()->id;

        $task->save();

        return redirect()->route('tasks.index')->with('success-message', 'Task saved Successfully!');

    }

    public function showMovedCustomers()
    {

        $page_title = $this->page_title;

        $tasks = Task::where('status', 1)->get();

        $employees = User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['admin', 'customer']);
        })->get();





        if (request()->ajax()) {
            $query = User::role('customer')
                ->with('employees', 'phone_number', 'customer_details')
                ->whereHas('customer_details')
                ->whereHas('moving_status', function ($query) {
                    $query->where('move_status', 1);
                })
                ->selectRaw('distinct users.*');

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $button = '';
                    $button .= "<a href=" . route('customer.show', $data->id) . " class='btn btn-sm btn-info mr-1 mb-1'> View </a>";

                    if (count($data->customerRelatedTasks) > 0) {
                        $button .= "<a href=" . route('assign-tasks.log', $data->id) . " class='btn btn-sm btn-success mr-1 mb-1'> Task Log </a>";
                    }

                    return $button;
                })
                ->addColumn('phone_number', function ($data) {
                    $data->phone_number ? $data->phone_number->number : "N/A";
                })
                ->addColumn('store_name', function ($data) {
                    return $data->customer_details ? $data->customer_details->store_name : "N/A";
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
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
                ->addColumn('checkbox', function ($data) {
                    $html = '
                    <input type="checkbox" value=' . $data->id . ' class="selected-customer" >';
                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'move_status', 'checkbox'])
                ->make(true);
        }

        return view('admin.task.assigned_customers')->with(compact('page_title', 'tasks', 'employees'));
    }



    public function taskLog($id)
    {
         $page_title = $this->page_title;
        $customer   = User::where('id', $id)
            ->with(['customerRelatedTasks' => function ($query) {
                $query->with('task', 'employee');
            }])->first();

        return view('admin.task.log')->with(compact('customer', 'page_title'));
    }

     public function allTasks()
    {
        $page_title = $this->page_title;
      $query = AssignedTask::with(['task', 'employee', 'assignee', 'customer' => function ($query) {
                $query->with('customer_details');
            }])
                ->when(count(array_intersect(['customer', 'admin'], Auth::user()->getRoleNames()->toArray())) == 0, function ($query) {
                    $query->where('assignee_id', Auth::user()->id);
                });


        if (request()->ajax()) {
            $query = AssignedTask::with(['task', 'employee', 'assignee', 'customer' => function ($query) {
                $query->with('customers');
            }])
                ->when(count(array_intersect(['customer', 'admin'], Auth::user()->getRoleNames()->toArray())) == 0, function ($query) {
                    $query->where('assignee_id', Auth::user()->id);
                });

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->status == 0) {
                        $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('my-tasks.submit') . '">';
                        $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                        $button .= '<input type="hidden" name="task_id" value="' . $data->id . '">';
                        $button .= '<button class="btn btn-primary btn-sm" type="submit">Set Completed</button>';

                        $button .= '</form>';
                    } else {
                        $button .= '<button class="btn btn-success btn-sm" type="submit">Completed</button>';
                    }

                    $button .= '<a href=' . route('customer.show', $data->customer_id) . ' class="btn btn-info btn-sm mt-2">View</a>';

                    return $button;
                })
                ->addColumn('title', function ($data) {
                    return $data->task->title;
                })
                ->addColumn('description', function ($data) {
                    return $data->task->description;
                })
                ->addColumn('employee', function ($data) {
                    return $data->employee->name;
                })
                ->addColumn('assignee', function ($data) {
                    return $data->assignee ? $data->assignee->name : "N/A";
                })
                // ->addColumn('customer', function ($data) {
                //     return $data->customer->name;
                // })
                // ->filterColumn('customer', function ($query, $keyword) {
                //     $query->whereHas('customer', function ($query) use ($keyword) {
                //         $query->where('name', 'like', "%" . $keyword . "%");
                //     });
                // })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->editColumn('completion_time', function ($data) {
                    return $data->completion_time ? $data->completion_time : "Pending";
                })
                ->addColumn('store_name', function ($data) {
                    return $data->customers ? $data->customers->store_name : "N/A";
                })
                // ->filterColumn('store_name', function ($query, $keyword) {
                //     $query->whereHas('customer', function ($query) use ($keyword) {
                //         $query->whereHas('customers', function ($query) use ($keyword) {
                //             $query->where('store_name', 'like', "%" . $keyword . "%");
                //         });
                //     });
                // })
                ->editColumn('status', function ($data) {
                    $html = '';
                    if ($data->status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->status == 1) {
                        $html .= '<span class="shadow-none badge badge-info">Completed</span>';
                    }
                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.task.all_tasks')->with(compact('page_title'));
    }

    public function submitTasks(Request $request)
    {
        $this->validate($request, [
            'task_id'             => 'required',
            'selected_customer.*' => 'required',
            'employee_id'         => 'required',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date',
        ]);

        foreach ($request->input(['selected_customer']) as $customer) {
            AssignedTask::updateOrCreate(
                [
                    'customer_id' => $customer,
                    'task_id'     => $request->input('task_id'),
                ],
                [
                    'customer_id' => $customer,
                    'employee_id' => $request->input('employee_id'),
                    'task_id'     => $request->input('task_id'),
                    'start_date'  => $request->input('start_date'),
                    'end_date'    => $request->input('end_date'),
                    'status'      => 0,
                    'assignee_id' => Auth::user()->id,
                ]
            );
        }

        // return redirect()->back()->with('success-message', 'Tasks assigned successfully!');
        echo "submitted";
    }

    public function submitMyTasks(Request $request)
    {
        // echo now();exit;
        $task = AssignedTask::where('id', $request->input('task_id'))->first();

        $task->status          = 1;
        $task->completion_time = now();

        $task->update();

        return redirect()->back()->with('success-message', 'Task completed and updated successfully!');

    }

    public function edit($id)
    {
         $page_title = $this->page_title;
        $task       = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error-message', 'Task not found in database!');
        }

        return view('admin.task.edit')->with(compact('task', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required|max:255',
            'description' => 'required',
        ]);

        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error-message', 'Task not found in database!');
        }
        $task->title       = $request->input('title');
        $task->description = $request->input('description');
        $task->status      = 1;
        $task->user_id     = Auth::user()->id;

        $task->update();

        return redirect()->route('tasks.index')->with('success-message', 'Task updated Successfully!');

    }






    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task->assigned_tasks) {
            $task->assigned_tasks->delete();
        }
        $task->delete();

        return redirect()->route('tasks.index')->with('success-message', 'Task deleted Successfully!');
    }


}



