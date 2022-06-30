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
        //$songs = Song::whereIn('song_id', $songs)->get("song_duration");
    
        $playlist= $request->session()->put($name, [["name" => $name, "songs" => $songs, "duration" =>$duration]]);
        return view("welcome", ["playlist" =>  $request->session()->get($name)]);
    }

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
                $request->session()->push($name .'.0.songs', $song_id);
            }
            $playlist= $request->session()->get($name);
            $songs = Song::whereIn('id', $playlist[0]["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            dd($songs);
            $playlist[0]["duration"]= $this->getduration($songs);
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
            $request->session()->pull($name .'.0.songs.'. $id);

            $playlist= $request->session()->get($name);
            $songs = Song::whereIn('id', $playlist[0]["songs"])->get();
            $select_songs= Song::orderBy('id')->get();
            $playlist[0]["duration"]= $this->getduration($songs);
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

    public function playlist_savedetails($id){
        $type= request("type");
        if($type == "session"){



        }elseif($type == "database"){
            $name= request("play_name");
            $playlist= Playlist::find($id);
            $playlist->name= $name;
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
        
        return gmdate("i:s", $time);
    }
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return "logged out!";
    }
}
