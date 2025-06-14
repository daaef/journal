<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserInterest;
use App\Repositories\Role\RoleContract;
use App\Repositories\User\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $repo;
    protected $roleRepo;

    public function __construct(UserContract $userContract, RoleContract $roleContract)
    {
        $this->repo = $userContract;
        $this->roleRepo = $roleContract;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->repo->getAll();
        return view('dashboard.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles  = $this->roleRepo->getAll();
        return view('dashboard.admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'country' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->repo->create($request);

        if (!$user) {
            $notification = array(
                'message' => 'User creation failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'User created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
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
    public function edit(string $uuid)
    {
        $user = $this->repo->findByUUID($uuid);
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->first();
        $interests = '';

        if ($userInterests && is_string($userInterests->interests)) {
            $decodedInterests = json_decode($userInterests->interests, true);
            if (is_array($decodedInterests)) {
                $interestsArray = Category::whereIn('uuid', $decodedInterests)->pluck('name')->toArray();
                $interests = implode(", ", $interestsArray);
            }
        }

        return view('user.settings', compact('user', 'interests'));
    }

    /**
     * Show the reviewer-specific settings page.
     */
    public function reviewerSettings(string $uuid)
    {
        $user = $this->repo->findByUUID($uuid);
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->first();
        $interests = '';

        if ($userInterests && is_string($userInterests->interests)) {
            $decodedInterests = json_decode($userInterests->interests, true);
            if (is_array($decodedInterests)) {
                $interestsArray = Category::whereIn('uuid', $decodedInterests)->pluck('name')->toArray();
                $interests = implode(", ", $interestsArray);
            }
        }

        return view('dashboard.reviewer.settings', compact('user', 'interests'));
    }

    /**
     * Show the admin-specific settings page.
     */
    public function adminSettings(string $uuid)
    {
        $user = $this->repo->findByUUID($uuid);
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->first();
        $interests = '';

        if ($userInterests && is_string($userInterests->interests)) {
            $decodedInterests = json_decode($userInterests->interests, true);
            if (is_array($decodedInterests)) {
                $interestsArray = Category::whereIn('uuid', $decodedInterests)->pluck('name')->toArray();
                $interests = implode(", ", $interestsArray);
            }
        }

        return view('dashboard.admin.settings', compact('user', 'interests'));
    }

    /**
     * Show the editor-specific settings page.
     */
    public function editorSettings(string $uuid)
    {
        $user = $this->repo->findByUUID($uuid);
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->first();
        $interests = '';

        if ($userInterests && is_string($userInterests->interests)) {
            $decodedInterests = json_decode($userInterests->interests, true);
            if (is_array($decodedInterests)) {
                $interestsArray = Category::whereIn('uuid', $decodedInterests)->pluck('name')->toArray();
                $interests = implode(", ", $interestsArray);
            }
        }

        return view('dashboard.editor.settings', compact('user', 'interests'));
    }

    public function interests()
    {
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->first();
        $interests = [];

        if ($userInterests && is_string($userInterests->interests)) {
            $decodedInterests = json_decode($userInterests->interests, true);
            if (is_array($decodedInterests)) {
                $interests = $decodedInterests;
            }
        }

        $categories = Category::all();

        return view('user.interests', compact('categories', 'interests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        // Find user first
        $user = $this->repo->findByUUID($uuid);

        if (!$user) {
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country' => 'required',
            'institution' => 'nullable|max:255',
            'old_password' => 'nullable|required_with:password',
            'password' => 'nullable|between:8,20|confirmed',
            'confirm_password' => 'nullable|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check password if provided
        if (!empty($request->password)) {
            if (empty($request->old_password)) {
                $notification = array(
                    'message' => 'Current password is required when setting a new password',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }
            
            if (!Hash::check($request->old_password, $user->password)) {
                $notification = array(
                    'message' => 'Current password is incorrect',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification)->withInput();
            }
        }

        $user = $this->repo->update($request, $uuid);

        if (!$user) {
            $notification = array(
                'message' => 'User update failed',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification)->withInput();
        }

        $notification = array(
            'message' => 'Account updated successfully',
            'alert-type' => 'success'
        );

        // Redirect based on user role
        if (Auth::user()->hasRole('Admin')) {
            return redirect()->route('admin.user.settings', $uuid)->with($notification);
        } elseif (Auth::user()->hasAnyRole(['Editor in Chief', 'Managing Editor'])) {
            return redirect()->route('editor.user.settings', $uuid)->with($notification);
        } elseif (Auth::user()->hasRole('Associate Editor') || Auth::user()->hasRole('Reviewer')) {
            return redirect()->route('reviewer.user.settings', $uuid)->with($notification);
        } else {
            return redirect()->route('user.settings', $uuid)->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
