<?php

namespace App\Repositories\UserInterest;

use App\Repositories\UserInterest\UserInterestContract;
use App\Models\UserInterest;

class EloquentUserInterestRepository implements UserInterestContract
{
    public function create($request)
    {

        // check if user has already saved interests
        $interest = UserInterest::where('user_id', auth()->user()->id)->first();

        if ($interest) {
            $interest->interests = json_encode($request->interests);
            $interest->save();
            return true;
        }

        $interest = new UserInterest();
        $interest->user_id = auth()->user()->id;
        // $interest->category_id = $interest;
        $interest->interests = json_encode($request->interests);
        $interest->save();
        return true;
    }
}
