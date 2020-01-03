<?php

namespace App\Http\Controllers;

use App\Game;
use App\Apk;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();

        return response()->json([
            "games" => $games
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
            'current_version' => 'required'
            
    ]);
    

    
    $game= Game::create($request->only('name','description','current_version'));

    return response()->json([
        "game" => $game
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
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $game = Game::whereId($id)->first();

        return response()->json([
            "game" => $game
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'current_version' => 'required'
            
        ]);

        $game = Game::find($id);
        $game->update($request->only('name','description','current_version'));

        return response()->json([
            "game" => $game
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
    public function downloadgames()
    {
        $games = Game::all();

        //return $users;
	    $csvExporter = new \Laracsv\Export();

	    return $csvExporter->build($games, ['id', 'name', 'description', 'status','updated_at'])->download('Games_list.csv');
    }
    public function deactivate($id)
    {
        $game = Game::find($id);

        if($game ->status == 'active'){
            $game ->status = 'inactive';
            $game ->save();
        
            return response()->json([
                "game_status" => $game->status
            ], 200);
        }
        else{
            $game ->status = 'active';
            $game ->save();
        
            return response()->json([
                "game_status" => $game->status
            ], 200);
        }
    }
    public function uploadFile(Request $request) {
        $file = Input::file('file');
        $filename = $file->getClientOriginalName();

        $path = hash( 'sha256', time());

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {
            $input['filename'] = $filename;
            $input['path'] = $path;
            $input['size'] = $file->getClientSize();
            $file = Apk::create($input);

            return response()->json([
                'success' => true,
                'id' => $file->id
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);
    }

}
