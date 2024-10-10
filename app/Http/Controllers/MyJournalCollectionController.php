<?php

namespace App\Http\Controllers;

use App\Repositories\MyJournalCollection\MyJournalCollectionContract;
use Illuminate\Http\Request;

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
                'message' => 'You need to login to download the journal.',
                'alert-type' => 'error'
            );

            // User is not authenticated, redirect to login page
            return redirect()->route('login')->with($notification);
        }
        // dd($request->all());
        //
        $journalExists = $this->repo->checkJournalInMyCollection($request);

        if($journalExists){
            $notification = array(
                'message' => 'Journal already exists in your collection.',
                'alert-type' => 'info'
            );
            return redirect()->back()->with($notification);
        }

        $result = $this->repo->addJournalToMyCollection($request);

        if ($result) {
            $notification = array(
                'message' => 'Journal added to your collection.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            return response()->json(['status' => false, 'message' => $result['message']]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function removeFromCollection(Request $request)
    {
        $result = $this->repo->removeJournalFromMyCollection($request);

        if ($result) {
            $notification = array(
                'message' => 'Journal removed from your collection.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            return response()->json(['status' => false, 'message' => $result['message']]);
        }
    }
}
