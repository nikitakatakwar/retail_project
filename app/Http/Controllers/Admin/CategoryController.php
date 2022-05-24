<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    /**
     * Class constructor.
     */
    public function __construct($page_title = null)
    {
        $this->page_title = "Manage Categories";
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
            $query = Category::all();
            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('category.edit', ['category' => $data->id]) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<form style="display: inline" id="frmDelete_' . $data->id . '" method="POST" action="' . route('category.destroy', ['category' => $data->id]) . '">';
                    $button .= '<input type="hidden" name="_method" value="DELETE">';
                    $button .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                    $button .= '<a href="#" onClick="deleteItem(' . $data->id . ');" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';

                    $button .= '</form>';
                    return $button;
                })
                ->addColumn('parent_category', function ($data) {
                    return $data->parent ? $data->parent->title : "N/A";
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at;
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.category.index')->with(compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title      = $this->page_title;
        $main_categories = Category::where('parent_id', null)
            ->where('status', 1)
            ->get();

        return view('admin.category.create')->with(compact('page_title', 'main_categories'));
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
            'title'  => 'required',
            'status' => 'required',
        ]);

        $category            = new Category();
        $category->title     = $request->input('title');
        $category->status    = $request->input('status');
        $category->parent_id = $request->input('parent_id');

        $category->save();

        return redirect()->route('category.index')->with('success-message', 'Category Saved Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title      = $this->page_title;
        $main_categories = Category::where('parent_id', null)
            ->where('status', 1)
            ->get();

        $category = Category::where('id', $id)
            ->with('parent')
            ->first();

        return view('admin.category.edit')->with(compact('page_title', 'main_categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'title'  => 'required',
            'status' => 'required',
        ]);

        $category->title     = $request->input('title');
        $category->status    = $request->input('status');
        $category->parent_id = $request->input('parent_id');

        $category->update();

        return redirect()->route('category.index')->with('success-message', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $children = 0;
        if (count($category->children) > 0) {
            $category->children()->delete();
            $children++;
        }
        $category->delete();

        if ($children > 0) {
            return redirect()->route('category.index')->with('success-message', 'Category Deleted Successfully along with subcategories!');
        } else {
            return redirect()->route('category.index')->with('success-message', 'Category Deleted Successfully!');
        }

    }
}
