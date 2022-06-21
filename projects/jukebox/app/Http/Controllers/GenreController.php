<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __contruct(){
        $this->middleware("auth");
    }
    //view genres
    public function view_genres(){
        $genres= Genre::orderBy('genre_id')->get();
        return view("genres.index_genres" , ["genres" => $genres]);
    }

    public function view_songs($id){
        return $genres= Genres::findOrFail($id);
    }

    public function create_playlist(){
        return view("playlist.create_playlist");
    }
}
