<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\Song;

class PlaylistController extends Controller
{
    //
    public function store_playlist(Request $request){
        $id= request("play_id");
        $name= request("play_name");
        $songs= request("songs");
        $duration= request("play_duration");
        $request->session()->put($name, [["id" => $id, "name" => $name, "songs" => $songs, "duration" =>$duration]]);
        return view("welcome", ["playlist" =>  $request->session()->get($name)]);
    }

    public function save_playlist(){
        $playlist= new Playlist(); 
        $playlist->playlist_name= request("play_name");
        $playlist->songs= implode(" ", request("songs"));
        $playlist->playlist_duration= request("play_duration");
        $playlist->save();

        $playlists= Playlist::orderBy('playlist_id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    public function playlist_overview($id){
        $playlist= Playlist::where('playlist_id', '=', $id)->get();
        return view("playlist.playlist_overview", ["playlist" => $playlist]);
    }

    public function playlist_details(Request $request, $name) {
        $playlist= $request->session()->get($name);
        $arr= [];
        $songs = Song::whereIn('song_id', $playlist[0]["songs"])->get();
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs]);
    }   
}
