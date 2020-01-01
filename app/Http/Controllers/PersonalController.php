<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;

class PersonalController extends Controller
{
    function edit($id)
    {
        $user = User::find($id);

        return response()->json([
            "user" => $user
        ],200);    
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        
        ]);

        $user = User::find($id);
        $user->update($request->only('firstname','lastname','email','phone','note'));

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'oldPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);
        
        $user = User::find($id);
        $user->update(['password'=> Hash::make($request->confirmPassword)]);
   
        return response()->json([
            "password_change" => true
        ], 200);
    }
}
