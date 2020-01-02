<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Joint;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exercises = Exercise::all();

        return response()->json([
            "exercises" => $exercises
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
    

    
    $exercise= Exercise::create($request->only('name','description'));
    //$exercise = Exercise::find(1);
    $joints_in= Joint::select('id')->whereIn('name', $request['masterlist1'])->pluck('id');

    $exercise->joints()->sync($joints_in);

    return response()->json([
        "exercise" => true
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
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exercise = Exercise::whereId($id)->first();

        return response()->json([
            "exercise" => $exercise
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            
        ]);

        $exercise = Exercise::find($id);
        $exercise->update($request->only('name','description'));

        return response()->json([
            "exercise" => $exercise
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercise $exercise)
    {
        //
    }
    public function downloadexercises()
    {
        $exercises = Exercise::all();

        //return $joints;
	    $csvExporter = new \Laracsv\Export();

	    return $csvExporter->build($exercises, ['id', 'name', 'description', 'status','updated_at'])->download('Exercises_list.csv');
    }
    public function deactivate($id)
    {
        $exercise = Exercise::find($id);

        if($exercise ->status == 'active'){
            $exercise ->status = 'inactive';
            $exercise ->save();
        
            return response()->json([
                "exercise_status" => $exercise->status
            ], 200);
        }
        else{
            $exercise ->status = 'active';
            $exercise ->save();
        
            return response()->json([
                "exercise_status" => $exercise->status
            ], 200);
        }
    }

    public function addJoints(Request $request, $id){

        $exercise = Exercise::find($id);

        $joints_in= Joint::select('id')->whereIn('name', $request[0])->pluck('id');
        $joints_out= Joint::select('id')->whereIn('name', $request[1])->pluck('id');

        $exercise->joints()->sync($joints_in);
        //$exercise->joints()->detach($joints_out);
        return response()->json([
            "attached" =>  true
        ], 200);
    }

    public function getJointsNotInExercise($id)
    {   
        if($id = null){
            $joints = Joint::whereDoesntHave('exercises')->get();
        }else{
            $joints = Joint::whereDoesntHave('exercises',function ($query) use($id){$query->where('id',$id);})->get();
        }
        
        return response()->json([
            "joints" => $joints
        ], 200);

        

        
        
    }

    public function getJointsInExercise($id)
    {   
        if($id = null){
        $joints = [];
        }else{
        $joints = Joint::whereHas('exercises',function ($query) use($id){$query->where('id',$id);})->get();
        }
        return response()->json([
            "joints" => $joints
        ], 200);
       

        // return response()->json([
        //     "users" => $users
        // ], 200);
    }
}
