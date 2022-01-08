<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Mail\JobInterest;
use Illuminate\Support\Facades\Mail;

class InterestController extends Controller{

    public function store(Job $job, Request $request){

        if($request->user()->id === $job->user_id){
            return response(
                ['message' => 'This action is unauthorized, user attemps to get interested in own post!'],
                403
            );
        } 

        if($job->interested($request->user())){

            return response(null, 409);
        }

        $response = $job->interests() -> create([
            'user_id'=>$request->user()->id,
        ]);

        if(!$job->interests()
            ->onlyTrashed()
            ->where('user_id', $request->user()->id)
            ->count()){
            //Mail::to($job->user)->send(new JobInterest(auth()->user(), $job));
        }
       
        return $response;
    } 

    public function destroy(Job $job, Request $request){

        return $request->user()->interests()->where('job_id', $job->id)->delete();
    }
}
