<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller{

    public function register (Request $request){

        $fields = $request->validate([
            'name' =>  'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'username' => 'required|string|unique:users,username'
        ]);

        $user = User::create($request->all());

        $token = $user->createToken('savagerytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return \response($response, 201);
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
