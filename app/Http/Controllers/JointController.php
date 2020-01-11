<?php

namespace App\Http\Controllers;

use App\Joint;
use App\Target;
use Illuminate\Http\Request;

class JointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getJointAndRoms(){

       $joints = Joint::with('roms')->get();

        return response()->json([
            "joints" => $joints 
        ], 200);
    }

    public function getExistingJointAndRoms(){

        $joints = Joint::with('targets','roms')->get();

        
        return response()->json([
            "joints" => $joints ,
            
        ], 200);
     }
     
     public function getExerciseRoms(Request $request){

        $exerciseNameList = json_decode($request->input('exerciseNames'),true);
        
        $joints = Joint::whereHas('exercises',function($query)use($exerciseNameList){$query->whereIn('name',$exerciseNameList);})->with('roms')->get();
        
         return response()->json([
             "joints" => $joints 
         ], 200);
     }

     public function getExerciseLimbs(Request $request){

        $exerciseNameList = json_decode($request->input('exerciseNames'),true);
        
        $limbs = Limb::whereHas('exercises',function($query)use($exerciseNameList){$query->whereIn('name',$exerciseNameList);})->with('limbs')->get();
        
         return response()->json([
             "limbs" => $limbs 
         ], 200);
     }
}
