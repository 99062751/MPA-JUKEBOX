<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Playlist extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    public function songs(){
        return $this->belongsToMany(Song::class);
    }

    // public function playlist_songs(){
    //     return $this->hasMany(Song::class);
    // }

    public function users(){
        return $this->belongsTo(User::class);
    }
    
}

