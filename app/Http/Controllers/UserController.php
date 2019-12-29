<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            "users" => $users
        ], 200);
    }

    public function edit($id)
    {
        $user = User::whereId($id)->first();

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function create(Request $request)
    {   

        $validatedData = $request->validate([
            
                'firstname' => 'required',
                'lastname' => 'required',
                'username' => 'required|unique:users',
                'phone' => 'required',
                'email' => 'required',
                'level' => 'required',
        ]);
        

        $password = Str::random(10);
        $user= User::create(array_merge($request->all(),['password' => Hash::make($password)]));

        return response()->json([
            "user" => $user
        ], 200);
    }
}
