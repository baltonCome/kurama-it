<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Job;

class JobController extends Controller{


    public function index(){

        return Job::orderBy('created_at', 'desc')->with(['user']);
    }

    public function show(Job $job){
        
        return [
            'job' => $job
        ];
    }

    public function store(Request $request){

        $fields = $request->validate([
            'job-title' => 'required|string',
            'job-type' => 'required|string',
            'location' => 'required|string',
            'salary' => 'required|float',
            'time-period' => 'required|string',
            'description' => 'required|string',
            'required-skills' => 'string',
        ]);

        $job = Job::create($request->all());

        return \response($job, 201);
    }

    public function search($title){

        return Job::where('job-title', 'like', '%'.$title.'%')->get();
    }

    public function update(Job $job){

        $this->authorize('update', $job);
        $job -> update();
        
        return $job;
    }

    public function destroy(Job $job){

        $this->authorize('delete', $job);
        $job->delete();

        return $job;
    }
}
