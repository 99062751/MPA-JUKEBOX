<?php

namespace App\Http\Controllers;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterval;

class SessionController extends Controller
    {
    // store_playlist session
    public function store_playlist(Request $request){
        $name= request("play_name");
        $songs= request("songs");
        $duration= "ok"; 
        
        $playlist= $request->session()->put("session_playlist", ["name" => $name, "songs" => $songs, "duration" =>$duration]);
        $playlist= $request->session()->get("session_playlist");
        return view("welcome", ["playlist" =>  $playlist]);
    }


    // save_playlist session
    public function save_session(Request $request){
        if($type == "session"){
            $session= $request->session()->get("session_playlist");
            $playlist= new Playlist();
            $playlist->name= $session["name"];
            $id_array= $session["songs"];
            $playlist->save();
            foreach($id_array as $id){
                $playlist_song= new Playlist_song();
                $playlist_song->playlist_id= $playlist->id;
                $playlist_song->song_id= $id;
                $playlist_song->save();
            }

            $playlists= Playlist::orderBy('id')->get();
            return view("welcome", ["playlists" => $playlists]);
        }else{
            return "werkt niet uwu";
        }
    }

    //details session
    public function session_details(Request $request){
        $playlist= $request->session()->get("session_playlist");
        $songs = Song::whereIn('id', $playlist["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist["duration"]= $this->getduration_session(collect($songs));

        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    // add song to session
    public function add_songsession(Request $request){
        $to_add_songs= request("songstoadd");
        foreach($to_add_songs as $song_id){
            $request->session()->push("session_playlist" .'.songs', $song_id);
        }
        $playlist= $request->session()->get("session_playlist");
        $songs = Song::whereIn('id', $playlist["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist["duration"]= $this->getduration_session($songs);
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }
    // retrieve song session
    function retrieve_songsession(Request $request){
        $id= request("song_id");
        $request->session()->pull("session_playlist" .'.songs.'. $id);
        $playlist= $request->session()->get("session_playlist");
        $songs = Song::whereIn('id', $playlist["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist["duration"]= $this->getduration_session(collect($songs));
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    public function getduration_session($songs){
        $duration_arr= $songs->pluck('duration');
        $time= 0; 
        foreach($duration_arr as $value){
            $value= Carbon::createFromFormat('H:i:s',  $value);
            $time= $time + $value->secondsSinceMidnight();
        }
        return gmdate("H:i:s", $time);
    }
}
