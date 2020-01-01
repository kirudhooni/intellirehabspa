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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'level' => 'required',
        ]);

        $user = User::find($id);
        $user->update($request->only('firstname','lastname','email','phone','note','level'));

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function downloadusers()
    {
        $users = User::all();

        //return $users;
	    $csvExporter = new \Laracsv\Export();

	    return $csvExporter->build($users, ['id', 'firstname', 'lastname', 'username', 'phone', 'level','status','email','note','updated_at'])->download('Users_list.csv');
    }
    public function deactivate($id)
    {
        $user = User::find($id);

        if($user ->status == 'active'){
            $user ->status = 'inactive';
            $user ->save();
        
            return response()->json([
                "user_status" => $user->status
            ], 200);
        }
        else{
            $user ->status = 'active';
            $user ->save();
        
            return response()->json([
                "user_status" => $user->status
            ], 200);
        }
    }

    public function getUsersNotInGroup($id)
    {
        $users = User::whereDoesntHave('groups',function ($query) use($id){$query->where('id',$id);})->get();
        
        
        return response()->json([
            "users" => $users
        ], 200);

        

        
        
    }

    public function getUsersInGroup($id)
    {
        $users = User::whereHas('groups',function ($query) use($id){$query->where('id',$id);})->get();
        
        return response()->json([
            "users" => $users
        ], 200);
       

        // return response()->json([
        //     "users" => $users
        // ], 200);
    }
}
