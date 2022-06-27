<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Models\Song;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $playlists= Playlist::orderBy('playlist_id')->get();
    return view("welcome", ["playlists" => $playlists]);
});

Route::get('/welcome', function (Request $request) {
    //$user = auth()->user();
    return view('welcome');
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name("dashboard");

require __DIR__.'/auth.php';


Route::get('genres/index_genres', [GenreController::class, "view_genres"])->name("genres.view_genres");
Route::get('playlist/create_playlist', [SongController::class, "get_songs"])->name("playlist.create_playlist");
Route::get('welcome', [PlaylistController::class, "store_playlist"])->name("playlist.store_playlist");
Route::get('save_playlist', [PlaylistController::class, "save_playlist"])->name("playlist.save_playlist");

Route::get('songs/{id}', [SongController::class, "songs_overview"])->name("songs.overview");
Route::get('song/details/{id}', [SongController::class, "songs_details"])->name("songs.details");
Route::get('/songs/add/{id}', [SongController::class, "songs_add"])->name("songs.add");
Route::get('/playlist/overview/{id}', [PlaylistController::class, "playlist_overview"])->name("playlist.overview");

Route::get('/playlist/details/{id}', [PlaylistController::class, "playlist_details"])->name("playlist.details");
// Route::get('/playlist/details/{name}', function (Request $request, $name) {
//     $playlist= $request->session()->get($name);
//     $arr= [];
//     foreach($playlist[0]["songs"] as $song_id){
//         $song= Song::where('song_id', '=', $song_id)->get();
//         $playlist[0]["songs"][$song_id]= $song;
//     }
//     //return $playlist[0]["songs"];
//     //return $arr;
//     //return $playlist[0]["songs"][$song_id];
//     return view("playlist.playlist_details", ["playlist" => $playlist, "test" => $playlist[0]["songs"]]);
// })->name("playlist.details");


