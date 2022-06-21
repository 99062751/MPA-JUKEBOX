<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('genres/index_genres', [GenreController::class, "view_genres"])->name("genres.view_genres");
Route::get('playlist/create_playlist', [GenreController::class, "create_playlist"])->name("playlist.create_playlist");
Route::get('welcome', [PlaylistController::class, "store_playlist"])->name("playlist.store_playlist");
Route::get('songs/{id}', [SongController::class, "songs_overview"])->name("songs.overview");
