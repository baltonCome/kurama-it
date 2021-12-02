<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class InterestController extends Controller{

    public function store(Job $job, Request $request){

        if($job->interested($request->user())){

            return response(null, 409);
        }


        return $job->interests() -> create([
            'user_id'=>$request->user()->id,
        ]);
    } 

    public function destroy(Job $job, Request $request){

        return $request->user()->interests()->where('job_id', $job->id)->delete();
    }
}
