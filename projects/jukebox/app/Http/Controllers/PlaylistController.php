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
    public function store_playlist(Request $request){
        $name= request("play_name");
        $songs= request("songs");
        $duration= "ok"; 
        
        $playlist= $request->session()->put("session_playlist", ["name" => $name, "songs" => $songs, "duration" =>$duration]);
        $playlist= $request->session()->get("session_playlist");
        return view("welcome", ["playlist" =>  $playlist]);
    }

    public function save_playlist(Request $request){
        $type= request("type");
        if($type == "database"){
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
        }elseif($type == "session"){
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

    public function render_dashboard(){
        return view("dashboard");
    }

    public function login_index(Request $request){
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    public function playlist_details(Request $request, $name) {
        $type= request("type");
        if($type == "session" && !isset($id)){
            $playlist= $request->session()->get("session_playlist");
            $songs = Song::whereIn('id', $playlist["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist["duration"]= $this->getduration($songs);
    
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else if($type == "database"){
            $id= request("id");
            $playlist= Playlist::find($id);
            $songs= Playlist::find($id)->songs()->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist->duration= $this->getduration(collect($songs));
            
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else{
            return "oop werkt niet";
        }

    }   

    public function addSong(Request $request, $name){
        $type= request("type");
        if($type == "session"){
            $to_add_songs= request("songstoadd");
            foreach($to_add_songs as $song_id){
                $request->session()->push("session_playlist" .'.songs', $song_id);
            }
            $playlist= $request->session()->get("session_playlist");
            $songs = Song::whereIn('id', $playlist["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist["duration"]= $this->getduration($songs);
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }elseif($type == "database"){
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
        }else{
            return "werkt niet uwu";
        }
            
    }
    
    public function retrieveSong(Request $request, $name){
        $type= request("type");
        if($type == "session"){
            $id= request("song_id");
            $request->session()->pull("session_playlist" .'.songs.'. $id);

            $playlist= $request->session()->get("session_playlist");
            $songs = Song::whereIn('id', $playlist["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist["duration"]= $this->getduration($songs);
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }elseif($type == "database"){
            $id= request("song_id");
            $playlist= Playlist::find($name);
            $playlist_song= Playlist_song::where('song_id', '=', $id);
            
            $playlist_song->delete();
            $songs= Playlist::find($name)->songs()->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist->duration= $this->getduration(collect($songs));
            
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else{
            return "werkt niet uwu";
        }
    }

    public function playlist_savedetails(Request $request, $id){
        $type= request("type");
        if($type == "database"){
            $name= request("play_name");
            $playlist= Playlist::find($id);
            $playlist["name"]= $name;
            $playlist->save();
    
            $songs= Playlist::find($id)->songs()->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist->duration= $this->getduration(collect($songs));
            
            return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
        }else{
            return "werkt niet uwu";
        }

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
        //dd($this->session);
        $playlist= $request->session()->get("session_playlist");
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists, "playlist" => $playlist]);
    }
}
