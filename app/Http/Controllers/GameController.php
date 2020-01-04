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
            'current_version' => 'required',
            'file' => 'required',
            ]);
        
        $path = hash( 'sha256', time());

        $path = $request->file('file')->storeAs(
            'apks/'.$path.'/',$request->file('file')->getClientOriginalName(), 'uploads'
        );
        $apk = new Apk;
        $apk->filename = $request->file('file')->getClientOriginalName();
        $apk->path = 'apks/'.$path.'/';
        $apk->size = $request->file('file')->getSize();
        $apk->version = $request->input('current_version');
        $apk->save();

       $game= Game::create($request->only('name','description','current_version'));

       $apk->games()->sync($game->id);
    return response()->json([
        "game_created" => true
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
        $validatedData = $request->validate([
            
            'game' => 'required',
            'version' => 'required',
            'file' => 'required',
            ]);
        
        $path = hash( 'sha256', time());

        $path = $request->file('file')->storeAs(
            'apks/'.$path.'/',$request->file('file')->getClientOriginalName(), 'uploads'
        );
        $apk = new Apk;
        $apk->filename = $request->file('file')->getClientOriginalName();
        $apk->path = 'apks/'.$path.'/';
        $apk->size = $request->file('file')->getSize();
        $apk->version = $request->input('version');
        $apk->save();

        $game_id = $request->input('game');
        
        $apk->games()->sync($game_id);
      

    return response()->json([
        "game_created" => true
    ], 200);
    }

}
