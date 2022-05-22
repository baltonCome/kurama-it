<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{


    public function index(){

        $users = User::orderBy('created_at', 'desc')->get();

        return [
            'users' =>$users,
        ];
    }

    public function userInterests(User $user){

        $jobs = $user->jobs()->with(['user', 'interests']);

        return [
            'user' =>$user,
            'jobs' =>$jobs
        ];
    }

    public function register (Request $request){

        $fields = $request->validate([
            'name' =>  'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'username' => 'required|string|unique:users,username'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => \bcrypt($fields['password']),
            'username' => $fields['username'],
        ]);

        $token = $user->createToken('savagerytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return \response($response, 201);
    }

    public function refresh(Request $request){

        $user = $request->user();
        $user->tokens()->delete();

        $token = $user->createToken('savagerytoken')->plainTextToken;

        $response = [
            'token' => $token
        ];
        
        return \response($response, 200);
    }

    public function login (Request $request){

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !\Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Unrecognized Credentials'
            ], 401);
        }

        $token = $user->createToken('savagerytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return \response($response, 201);
    }

    public function logout(Request $request){
        
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Session ended'
        ];
    }

    
    public function search($username){

        return User::where('username', 'like', '%'.$username.'%')->get();
    }

    public function update(Request $request, $id){

        if(User::find($id)){
            $user = User::find($id);
            $user -> update($request->all());

            return User::find($id);
        }
        return ['message' => 'Selected profile does not exist'];
    }
}
