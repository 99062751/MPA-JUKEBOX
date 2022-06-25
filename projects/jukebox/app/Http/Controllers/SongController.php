<?php

namespace App\Http\Controllers;
use App\Models\Song;

class SongController extends Controller
{
    //
    public function songs_overview($id){
        $songs= Song::where('song_type', '=', $id)->get();
        return view("songs.songs_overview", ["songs" => $songs]);
    }

    public function songs_details($id){
        $song= Song::where('song_id', '=', $id)->get();
        return view("songs.songs_details", ["song" => $song]);
    }

    public function get_songs(){
        $songs= Song::orderBy('song_id')->get();
        return view("playlist.create_playlist", ["songs" => $songs]);
    }

    public function songs_add($id){
        return "OK";
    }
}
