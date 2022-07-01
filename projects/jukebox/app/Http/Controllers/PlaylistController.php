<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use App\Models\Playlist_song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterval;
use App\Models\Song;


class PlaylistController extends Controller
{
    
    public function save_playlist(){
        $playlist= new Playlist(); 
        $playlist->name= request("play_name");
        $id_array= request("songs");
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

    public function render_dashboard(){
        return view("dashboard");
    }

    public function login_index(){
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    public function playlist_details($name) {
        $id= request("id");
        $playlist= Playlist::find($id);
        $songs= Playlist::find($id)->songs()->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist->duration= $this->getduration(collect($songs));
        
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }   

    public function addSong($name){
        $id_array= request("songstoadd");
        $playlist= Playlist::find($name);
        foreach($id_array as $id){
            $playlist_song= new Playlist_song();
            $playlist_song->playlist_id= $name;
            $playlist_song->song_id= $id;
            $playlist_song->save();
        }

        $songs= Playlist::find($name)->songs()->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist->duration= $this->getduration(collect($songs));

        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }
    
    public function retrieveSong($name){
        $id= request("song_id");
        $playlist= Playlist::find($name);
        $playlist_song= Playlist_song::where('song_id', '=', $id);
        
        $playlist_song->delete();
        $songs= Playlist::find($name)->songs()->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist->duration= $this->getduration(collect($songs));
        
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    public function playlist_savedetails($id){
        $name= request("play_name");
        $playlist= Playlist::find($id);
        $playlist["name"]= $name;
        $playlist->save();

        $songs= Playlist::find($id)->songs()->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist->duration= $this->getduration(collect($songs));
        
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }

    public function getduration($songs){
        $duration_arr= $songs->pluck('duration');
        $time= 0; 
        foreach($duration_arr as $value){
            $value= Carbon::createFromFormat('H:i:s',  $value);
            $time= $time + $value->secondsSinceMidnight();
        }
        return gmdate("H:i:s", $time);
    }
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return "logged out!";
    }

    public function index(Request $request){
        $playlist= $request->session()->get("session_playlist");
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists, "playlist" => $playlist]);
    }
}
