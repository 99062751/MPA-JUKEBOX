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
}
