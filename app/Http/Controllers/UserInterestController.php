<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Category\CategoryContract;
use App\Repositories\UserInterest\UserInterestContract;

class UserInterestController extends Controller
{

    protected $repo;
    protected CategoryContract $categoryRepo;

    public function __construct(UserInterestContract $userInterestContract, CategoryContract $categoryContract)
    {
        $this->repo = $userInterestContract;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // validate the request
        $request->validate([
            'interests' => 'required|array'
        ]);

        $interests = $this->repo->create($request);

        if (!$interests) {
            $notification = array(
                'message' => 'Failed to save interests',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        return redirect()->route('dashboard')->with('success', 'Interests updated successfully');
    }


}
