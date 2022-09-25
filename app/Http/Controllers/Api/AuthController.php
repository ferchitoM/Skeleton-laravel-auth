<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function register(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'roles_id' => 2, //All registered user have the USER role (id=2)
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $new_user = User::create($request->all());
        // $new_user->save();

        return response([
            'message' => 'Tu registro se realizó exitósamente.'
        ]);
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (!Auth::attempt($request->all())) {
            return response([
                'errors' => ['message' => 'Credenciales incorrectas.']
            ], 403);
        }

        // dd($request->user()->roles->code);

        return response([
            'user' =>  $request->user(),
            'role' => $request->user()->roles->code, //User role code (A: amdin, U: user)
            'token' => $request->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response([
            'message' => 'La sesión se cerró correctamente.'
        ], 200);
    }

    //* GET USER DATA
    public function user() {

        return response([
            'user' => auth()->user(),
        ], 200);
    }
}
