<?php

namespace App\Http\Controllers;

use App\Repositories\SubCategory\SubCategoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{

    protected $repo;
    public function __construct(SubCategoryContract $subCategoryContract)
    {
        $this->repo = $subCategoryContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = $this->repo->getAll();
        return view('dashboard.admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.subcategories.create');
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
            'message' => 'SubCategory Created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('subcategories.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->repo->findById($id);
        return view('', compact('category'));
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
        return redirect()->route('subcategories.index')->with($notification);
    }

    public function getSubCategoriesByID(Request $request){
        $subcategories = $this->repo->findByCategory($request->category_id);
        return response()->json($subcategories);
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
        return redirect()->route('subcategories.index')->with($notification);
    }
}
