<?php

namespace App\Http\Controllers;

use App\Repositories\SubSubCategory\SubSubCategoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubSubCategoryController extends Controller
{

    protected $repo;
    public function __construct(SubSubCategoryContract $subSubCategoryContract)
    {
        $this->repo = $subSubCategoryContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subsubcategories = $this->repo->getAll();
        return view('dashboard.admin.subsubcategories.index', compact('subsubcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.subsubcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->repo->create($request);

        $notification = array(
            'message' => 'Created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('sub-subcategories.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->repo->findByUUID($id);
        return view('dashboard.admin.subcategories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->repo->update($request, $id);

        $notification = array(
            'message' => 'Category updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('sub-subcategories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repo->delete($id);
        $notification = array(
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('sub-subcategories.index')->with($notification);
    }
}
