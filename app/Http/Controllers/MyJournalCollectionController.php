<?php

namespace App\Http\Controllers;

use App\Repositories\MyJournalCollection\MyJournalCollectionContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MyJournalCollectionController extends Controller
{

    protected $repo;

    public function __construct(MyJournalCollectionContract $myJournalCollectionContract)
    {
        $this->repo = $myJournalCollectionContract;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            $notification = array(
                'message' => 'You need to login to add journals to your collection.',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        }

        // Validate request with proper security
        $validator = Validator::make($request->all(), [
            'journal_id' => 'required|integer|exists:journals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Use authenticated user ID for security
        $request->merge(['user_id' => auth()->id()]);
        
        $journalExists = $this->repo->checkJournalInMyCollection($request);

        if($journalExists){
            $notification = array(
                'message' => 'Journal already exists in your collection.',
                'alert-type' => 'info'
            );
            return redirect()->back()->with($notification);
        }

        // Use database transaction for data integrity
        try {
            DB::transaction(function () use ($request) {
                $result = $this->repo->addJournalToMyCollection($request);
                
                if (!$result) {
                    throw new \Exception('Failed to add journal to collection');
                }
            });
            
            $notification = array(
                'message' => 'Journal added to your collection.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
            
        } catch (\Exception $e) {
            Log::error('Add to collection error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'journal_id' => $request->journal_id,
                'ip' => $request->ip()
            ]);
            
            $notification = array(
                'message' => 'Error adding journal to collection. Please try again.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function removeFromCollection(Request $request)
    {
        if (!auth()->check()) {
            $notification = array(
                'message' => 'You need to login to remove journals from your collection.',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        }

        // Validate request with proper security
        $validator = Validator::make($request->all(), [
            'journal_id' => 'required|exists:journals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Use authenticated user ID for security
        $request->merge(['user_id' => auth()->id()]);
        
        // Use database transaction for data integrity
        try {
            DB::transaction(function () use ($request) {
                $result = $this->repo->removeJournalFromMyCollection($request);
                
                if (!$result) {
                    throw new \Exception('Failed to remove journal from collection');
                }
            });
            
            $notification = array(
                'message' => 'Journal removed from your collection.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
            
        } catch (\Exception $e) {
            Log::error('Remove from collection error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'journal_id' => $request->journal_id,
                'ip' => $request->ip()
            ]);
            
            $notification = array(
                'message' => 'Error removing journal from collection. Please try again.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}

