<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterval;
use App\Models\Song;


class PlaylistController extends Controller
{

    public function store_playlist(Request $request){
        $name= request("play_name");
        $songs= request("songs");
        $duration= "ok"; 
        //$songs = Song::whereIn('song_id', $songs)->get("song_duration");
    
        $playlist= $request->session()->put($name, [["name" => $name, "songs" => $songs, "duration" =>$duration]]);
        return view("welcome", ["playlist" =>  $request->session()->get($name)]);
    }

    public function save_playlist(){
        $playlist= new Playlist(); 
        $playlist->name= request("play_name");
        //dd(implode(" ", request("songs")));
        
        $playlist->songs= implode(",", request("songs"));
        //$playlist->duration= request("duration");
        $playlist->save();

        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    //playlist = [1:[name: test], 2:[name: hond]]

    // public function playlist_overview($id){
    //     $playlist= Playlist::where('playlist_id', '=', $id)->get();
    //     return view("playlist.playlist_overview", ["playlist" => $playlist]);
    // }

    public function playlist_overview(){
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    public function playlist_details(Request $request, $name) {
        $type= request("type");
        if($type == "session" && !isset($id)){
            $playlist= $request->session()->get($name);
            $songs = Song::whereIn('id', $playlist[0]["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist[0]["duration"]= $this->getduration($songs);
    
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else if($type == "database"){
            $id= request("id");
            $playlist= Playlist::find($id);
            $returnme= explode(",", $playlist["songs"]);
            $songs= [];
            foreach($returnme as $index){
                $songs[$index] = Song::find($index);
            }
            $select_songs= Song::orderBy('id')->get();
            $playlist->duration= $this->getduration(collect($songs));
            
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else{
            return "oop werkt niet";
        }

    }   

    public function getduration($songs){
        $duration_arr= $songs->pluck('duration');
        $time= 0; 
        foreach($duration_arr as $value){
            $value= Carbon::createFromFormat('H:i:s',  $value);
            $time= $time + $value->secondsSinceMidnight();
        }

        //dd(gmdate("i:s", $time));
        
        return gmdate("i:s", $time);
    }

    public function addToSession(Request $request, $name){
        $to_add_songs= request("songstoadd");
        foreach($to_add_songs as $song_id){
            $request->session()->push($name .'.0.songs', $song_id);
        }
        $playlist= $request->session()->get($name);
        $songs = Song::whereIn('id', $playlist[0]["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist[0]["duration"]= $this->getduration($songs);
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }
    
    public function retrieveFromSession(Request $request, $name){
        $id= request("song_id");
        $request->session()->pull($name .'.0.songs.'. $id);

        $playlist= $request->session()->get($name);
        $songs = Song::whereIn('id', $playlist[0]["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist[0]["duration"]= $this->getduration($songs);
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return "logged out!";
    }
}
