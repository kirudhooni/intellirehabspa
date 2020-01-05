<?php

namespace App\Http\Controllers;

use App\Target;
use App\Joint;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $targets = Target::all();

        return response()->json([
            "targets" => $targets
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'name' => 'required',
            'rom_value' => 'required'
            
    ]);

        $target= Target::create($request->only('name', 'description'));
        
        $jointData = json_decode($request->input('rom_value'),true);
        
        foreach($jointData as $joint){
            foreach( $joint['roms'] as $rom){
                $joint_id = $rom['pivot']['joint_id'];
                $value= $rom['value'];
                
                $target->joints()->attach($joint_id, [
                    'rom_value' => $value,
                    'rom_id' => $rom['id']
                ]);
            }
        }
        

        
        return response()->json([
            "target_saved" =>  true
        ],200);
    }
    public function update(Request $request,$id)
    {   
        $validatedData = $request->validate([
            
            'name' => 'required',
            'rom_value' => 'required'
            
    ]);
        
        $target= Target::find($id);
        $target->update($request->only('name', 'description'));

        
        

        

        $jointData = json_decode($request->input('rom_value'),true);
        
        //$test = $target->joints;
        foreach($jointData as $joint){
            $target->joints()->detach($joint['id']);
            foreach( $joint['targets'] as $targethere){
                $joint_id = $targethere['pivot']['joint_id'];
                $value= $targethere['pivot']['rom_value'];
                
                
                $target->joints()->attach($joint_id,[
                    'rom_value' => $value,
                    'rom_id' => $targethere['pivot']['rom_id']
                ]);
            }
        }
        
        
        
        return response()->json([
            "target_updated" =>  $jointData
        ],200);
    }
    public function downloadtargets()
    {
        $targets = Target::all();

        //return $users;
	    $csvExporter = new \Laracsv\Export();

	    return $csvExporter->build($targets, ['id', 'name', 'description', 'status','updated_at'])->download('Targets_list.csv');
    }
    public function deactivate($id)
    {
        $target = Target::find($id);

        if($target ->status == 'active'){
            $target ->status = 'inactive';
            $target ->save();
        
            return response()->json([
                "target_status" => $target->status
            ], 200);
        }
        else{
            $target ->status = 'active';
            $target ->save();
        
            return response()->json([
                "target_status" => $target->status
            ], 200);
        }
    }

    
}
