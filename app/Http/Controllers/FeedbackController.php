<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller{
    
    public function index(){

        $feedbacks = Feedback::orderBy('created_at', 'desc')->with(['user'])->get();

        return [
            'feedbacks' => $feedbacks
        ];
    }

    public function store(Request $request){

        $fields = $request->validate([

            'rating' => 'required',
            'testimony' => 'string'
        ]);

        $feedback = new Feedback($fields);
        $feedback -> user()->associate($request->user());
        $feedback->save();

        return \response($feedback, 201);
    }

    public function destroy($id){
        
        $feedback = Feedback::find($id);
        $this->authorize('sameuser', $feedback);
        $feedback->delete();

        return $feedback;
    }
}
