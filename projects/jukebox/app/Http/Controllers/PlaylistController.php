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
    //laad het dashboard in als je ingelogd ben
    public function render_dashboard(){
        return view("dashboard");
    }
    
    //laad de index in als je ingelogd ben
    public function login_index(){
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists]);
    }

    //details page playlist 
    public function playlist_details($name) {
        $id= request("id");
        $playlist= Playlist::find($id);
        $songs= Playlist::find($id)->songs()->get();
        $select_songs= Song::orderBy('id')->get();
        $playlist->duration= $this->getduration(collect($songs));
        
        return view("playlist.playlist_details", ["playlist" => $playlist, "songs" => $songs, "select_songs" => $select_songs]);
    }   

    // voegt een song toe bij playlist
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
    
    // verwijderd een song van playlist
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

    //slaat de nieuwe naam op in playlist 
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


    // berekend en geeft de duration terug van playlist
    public function getduration($songs){
        $duration_arr= $songs->pluck('duration');
        $time= 0; 
        foreach($duration_arr as $value){
            $value= Carbon::createFromFormat('H:i:s',  $value);
            $time= $time + $value->secondsSinceMidnight();
        }
        return gmdate("H:i:s", $time);
    }
    
    //logt de gebruiker uit en laad nieuwe pagina in
    public function logout(){
        Session::flush();
        Auth::logout();
        return "logged out!";
    }
    //laad de index in als je niet ingelogd ben
    public function index(Request $request){
        $playlist= $request->session()->get("session_playlist");
        $playlists= Playlist::orderBy('id')->get();
        return view("welcome", ["playlists" => $playlists, "playlist" => $playlist]);
    }
}
