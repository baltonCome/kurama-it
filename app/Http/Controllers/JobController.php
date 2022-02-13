<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Job;

class JobController extends Controller{

    public function index(){

        $jobs = Job::orderBy('created_at', 'desc')->with(['user'])->get();

        return [
            'jobs' =>$jobs
        ];
    }

    public function show(Job $job){
        
        return [
            'job' => $job
        ];
    }

    public function store(Request $request){

        $fields = $request->validate([
            'title' => 'required|string',
            'job_type' => 'required|string',
            'location' => 'required|string',
            'salary' => 'required',
            'time_period' => 'required|string',
            'description' => 'required|string',
            'required_skills' => 'string',
        ]);

        $job = new Job($fields);
        $job->user()->associate($request->user());
        $job->save();
        //$job = Job::create($request->all());

        return \response($job, 201);
    }

    public function search($title){ 

        return Job::where('title', 'like', '%'.$title.'%')->get();
    }

    public function update(Request $request, $id){

        $job = Job::find($id);
        $this->authorize('sameuser', $job);
        $job -> update($request->all());
        
        return $job;
    }

    public function destroy($id){

        $job = Job::find($id);

        $this->authorize('sameuser', $job);
        $job->delete();

        return $job;
    }
}