<?php

namespace App\Http\Controllers;

use App\Joint;
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
}
