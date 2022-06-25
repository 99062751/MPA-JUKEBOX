@foreach($song as $s)
    <div>
        <h2>Details</h2>
            <h4>Name song</h4>
            <p>{{ $s["song_name"] }}</p>
        

            <h4>Artist</h4>
            <p>{{ $s["artist"] }}</p>

            <h4>Duration</h4>
            <p>{{ date("H:s", strtotime($s["song_duration"])) }}</p>

            <a href="{{ route('songs.add', $s['song_id']) }}">Add to playlist</a>
    </div>
@endforeach
