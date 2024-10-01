<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected $repo;
    public function __construct(CategoryContract $categoryContract)
    {
        $this->repo = $categoryContract;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repo->getAll();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
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
            'message' => 'Category Created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('categories.index')->with($notification);
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
        return view('categories.edit', compact('category'));
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
        return redirect()->route('categories.index')->with($notification);
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
        return redirect()->route('categories.index')->with($notification);
    }
}
