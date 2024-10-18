<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Category\CategoryContract;

class UserInterestController extends Controller
{

    protected CategoryContract $categoryRepo;

    public function __construct(CategoryContract $categoryContract)
    {
        $this->categoryRepo = $categoryContract;
    }



    /**
     * Display a listing of the resource.
     */
    public function interests()
    {
        $categories = $this->categoryRepo->getAll();
        return view('interests', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        // validate the request
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        //get the authenticated user
        $user = auth()->user();
        // attach the categories to the user
        $user->userInterests()->attach($request->categories);
        return redirect()->route('dashboard')->with('success', 'Interests updated successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
