<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Song;

class SongController extends Controller
{
    //
    public function songs_overview($id){
        $songs= Genre::find($id)->songs();
        return view("songs.songs_overview", ["songs" => $songs]);
    }

    public function songs_details($id){
        $song= Song::find($id);
        return view("songs.songs_details", ["song" => $song]);
    }

    public function get_songs(){
        $songs= Song::orderBy('id')->get();
        return view("playlist.create_playlist", ["songs" => $songs]);
    }

    public function songs_add($id){
        return "OK";
    }
}
