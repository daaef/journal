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
        // dd($request->all());
        //
        $journalExists = $this->repo->checkJournalInMyCollection($request);

        if($journalExists){
            $notification = array(
                'message' => 'Journal already exists in your collection',
                'alert-type' => 'info'
            );
            return redirect()->back()->with($notification);
        }

        $result = $this->repo->addJournalToMyCollection($request);

        if ($result) {
            $notification = array(
                'message' => 'Journal added to your collection successfully',
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
    public function destroy(string $id)
    {
        //
    }
}
