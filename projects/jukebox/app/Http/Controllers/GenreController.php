<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    //view genres
    public function view_genres(){
        $genres= Genre::orderBy('id')->get();
        return view("genres.index_genres" , ["genres" => $genres]);
    }
}
