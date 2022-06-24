<h1>PLATYLIST</h1>
<div>   
    <form action="{{ route('playlist.store_playlist') }}">
        <label for="name">Naam playlist</label>
        <input type="text" name="play_name" id="play_name"><br />

        <label for="name">Songs</label>
        <input type="text" name="songs" id="songs"><br />

        <label for="name">Duration</label>
        <input type="time" name="play_duration" id="play_duration"><br />

        <input type="submit" value="Create Playlist"></input>
    </form>
</div>

