<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    //
    public function store_playlist(){
        $playlist= new Playlist(); 
        $playlist->playlist_name= request("play_name");
        $playlist->songs= request("songs");
        $playlist->playlist_duration= request("play_duration");
        $playlist->save();
        return redirect("/")->with("msg", "Thanks for your order!");
    }
}
