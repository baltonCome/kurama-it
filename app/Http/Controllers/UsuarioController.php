<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\Response;

class UsuarioController extends Controller{

    public function index(Usuario $usuario){

        $jobs = $usuario->jobs()->with(['usuario', 'interests']);

        return [
            'usuario' =>$usuario,
            'jobs' =>$jobs 
        ];
    }

    public function register (Request $request){

        $fields = $request->validate([
            'name' =>  'required|string',
            'email' => 'required|string|unique:usuarios,email',
            'password' => 'required|string|confirmed',
            'username' => 'required|string|unique:usuarios,username'
        ]);

        $usuario = Usuario::create($request->all());

        $response = [
            'usuario' => $usuario
        ];

        return \response($response, 201);
    }

    public function login (Request $request){

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $usuario = Usuario::where('email', $fields['email'])->first();

        if(!$usuario || !\Hash::check($fields['password'], $usuario->password)){
            return response([
                'message' => 'Unrecognized Credentials'
            ], 401);
        }

        $response = [
            'usuario' => $usuario
        ];

        return \response($response, 201);
    }

    public function logout(Request $request){
        
        auth()->usuario()->tokens()->delete();

        return [
            'message' => 'Session ended'
        ];
    }

    
    public function search($usuarioname){

        return Usuario::where('username', 'like', '%'.$username.'%')->get();
    }

    public function update(Request $request, $id){

        if(Usuario::find($id)){
            $usuario = Usuario::find($id);
            $usuario -> update($request->all());

            return Usuario::find($id);
        }
        return ['message' => 'Selected profile does not exist'];
    }
}
