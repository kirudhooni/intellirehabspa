<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        return response()->json([
            "groups" => $groups
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            
            'name' => 'required',
            
    ]);
    

    
    $group= Group::create($request->only('name','description'));

    return response()->json([
        "group" => $group
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::whereId($id)->first();

        return response()->json([
            "group" => $group
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            
        ]);

        $group = Group::find($id);
        $group->update($request->only('name','description'));

        return response()->json([
            "group" => $group
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
    public function downloadgroups()
    {
        $groups = Group::all();

        //return $users;
	    $csvExporter = new \Laracsv\Export();

	    return $csvExporter->build($groups, ['id', 'name', 'description', 'status','updated_at'])->download('Groups_list.csv');
    }
    public function deactivate($id)
    {
        $group = Group::find($id);

        if($group ->status == 'active'){
            $group ->status = 'inactive';
            $group ->save();
        
            return response()->json([
                "group_status" => $group->status
            ], 200);
        }
        else{
            $group ->status = 'active';
            $group ->save();
        
            return response()->json([
                "group_status" => $group->status
            ], 200);
        }
    }

    public function addUsers(Request $request, $id){

        $group = Group::find($id);

        $users_in= User::select('id')->whereIn('username', $request[0])->pluck('id');
        $users_out= User::select('id')->whereIn('username', $request[1])->pluck('id');

        $group->users()->sync($users_in);
        //$group->users()->detach($users_out);
        return response()->json([
            "attached" =>  true
        ], 200);
    }
}
