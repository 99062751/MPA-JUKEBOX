<h1>Song overview</h1>
@foreach($songs as $song)
<div>
    <h1>{{ $song->name }}</h1>
    <p>{{ $song->artist }}</p>
    <a href="{{ route('songs.details', $song['song_id']) }}">DETAILS SONG</a>
</div>
@endforeach