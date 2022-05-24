<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct($page_title = null)
    {
        $this->page_title = "Manage Packages";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = $this->page_title;
        if (request()->ajax()) {
            return DataTables::of(Package::all())
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('package.edit', ['package' => $data->id]) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('admin.destroy', ['admin' => $data->id]) . '">';
                    $button .= '<input type="hidden" name="_method" value="DELETE">';
                    $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    if ($data->id != 1) {
                        $button .= '<a href="#" onClick="deleteItem(' . $data->id . ');" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';
                    }

                    $button .= '</form>';
                    return $button;
                })
                ->editColumn('status', function ($data) {
                    $html = '';
                    if ($data->status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Inactive</span>';
                    } elseif ($data->status == 1) {
                        $html .= '<span class="shadow-none badge badge-primary">Active</span>';
                    }
                    return $html;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.package.index')->with(compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = $this->page_title;
        return view('admin.package.create')->with(compact('page_title'));
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
            'title'       => 'required|unique:packages',
            'price'       => 'required|numeric',
            'description' => 'required',
            'status'      => 'required',
        ]);

        $package              = new Package;
        $package->title       = $request->input('title');
        $package->price       = $request->input('price');
        $package->status      = $request->input('status');
        $package->description = $request->input('description');

        $package->save();

        return redirect()->route('package.index')->with('success-message', 'Package Saved Successfully!');
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
        $package    = Package::find($id);
        $page_title = $this->page_title;
        return view('admin.package.edit')->with(compact('page_title', 'package'));
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
            'title'       => 'required|unique:packages,title,' . $id,
            'price'       => 'required|numeric',
            'description' => 'required',
            'status'      => 'required',
        ]);

        $package              = Package::find($id);
        $package->title       = $request->input('title');
        $package->price       = $request->input('price');
        $package->status      = $request->input('status');
        $package->description = $request->input('description');

        $package->update();

        return redirect()->route('package.index')->with('success-message', 'Package Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Package::where('id', $id)->delete();
        return redirect()->route('package.index')->with('success-message', 'Package Deleted Successfully!');
    }
}
