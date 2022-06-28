
    <div>
        <h2>Details</h2>
            <h4>Name song</h4>
            <p>{{ $song->name }}</p>
        

            <h4>Artist</h4>
            <p>{{ $song->artist }}</p>

            <h4>Duration</h4>
            <p>{{ date("H:i:s", strtotime($song->duration)) }}</p>

            <a href="{{ route('songs.add', $song->id) }}">Add to playlist</a>
    </div>

