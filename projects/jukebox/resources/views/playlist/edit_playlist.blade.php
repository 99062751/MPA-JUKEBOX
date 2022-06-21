@extends('layouts.layout')
@section('content')
<h1>PLATYLIS</h1>
<div>   
    <form action="">
        <label for="name">Naam playlist</label>
        <input type="text" name="name" id="name_play">
        <button href="/create_playlist">Update Playlist</button>
    </form>
</div>
@endsection

