<h1>PLATYLIST</h1>
<div>   
    @if (Auth::check())
    <form action="{{ route('playlist.save_playlist') }}">
        <input type="hidden" name="type" value="database">
    @else
    <form action="{{ route('playlist.store_playlist') }}">
    @endif
        <label for="name">Naam playlist</label>
        <input type="text" name="play_name" id="play_name"><br /><br>

        <label for="name">Songs</label><br>
        <select name="songs[]" multiple size="4">
            @foreach($songs as $song)
            <option value="{{ $song->id }}">{{ $song->name }}</option>
            @endforeach
        </select>
    <br>
    <br>

        <!-- <label for="name">Duration</label>
        <input type="disabled" name="play_duration" id="play_duration"><br /> -->
        <input type="submit" value="Create Playlist">
    </form>
</div>

