<?php

namespace App\Http\Controllers;
use App\Models\Song;
use App\Models\Playlist;
use App\Models\Playlist_song;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterval;

class SessionController
    {
    // slaat de playlist in een session op
    public function store_playlist(Request $request){
        $name= request("play_name");
        $songs= request("songs");
        $duration= "ok"; 
        
        $playlist= $request->session()->put("session_playlist", ["name" => $name, "songs" => $songs, "duration" =>$duration]);
        $playlist= $request->session()->get("session_playlist");
        return view("welcome", ["playlist" =>  $playlist]);
    }

    //details page session 
    public function session_details(Request $request){
        $playlist= $request->session()->get("session_playlist");
        $songs = Song::whereIn('id', $playlist["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist["duration"]= $this->getduration_session(collect($songs));

        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    // voegt een song toe bij session
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
    // verwijderd een song van session
    function retrieve_songsession(Request $request){
        $id= request("song_id");
        $request->session()->pull("session_playlist" .'.songs.'. $id);
        $playlist= $request->session()->get("session_playlist");
        $songs = Song::whereIn('id', $playlist["songs"])->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist["duration"]= $this->getduration_session(collect($songs));
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    // berekend en geeft de duration terug van playlist session
    public function getduration_session($songs){
        $duration_arr= $songs->pluck('duration');
        $time= 0; 
        foreach($duration_arr as $value){
            $value= Carbon::createFromFormat('H:i:s',  $value);
            $time= $time + $value->secondsSinceMidnight();
        }
        return gmdate("H:i:s", $time);
    }

    //slaat de session op in playlist database
    public function save_playlistsession(Request $request){
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
    }
}
