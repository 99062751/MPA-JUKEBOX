<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Song;

class SongController extends Controller
{
    //laat overview van alle songs zien op genre
    public function songs_overview($id){
        
        $songs= Genre::find($id)->songs()->get();
        return view("songs.songs_overview", ["songs" => $songs]);
    }

    //laat een detail pagina per song zien
    public function songs_details($id){
        $song= Song::find($id);
        return view("songs.songs_details", ["song" => $song]);
    }

    //pakt alle songs en laat ze in een overzicht zien
    public function get_songs(){
        $songs= Song::orderBy('id')->get();
        return view("playlist.create_playlist", ["songs" => $songs]);
    }
}
