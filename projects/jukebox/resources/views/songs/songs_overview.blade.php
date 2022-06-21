@foreach($songs as $song)
<div>
    <p>test</p>
    <h1>{{ $song["song_name"] }}</h1>
    <p>{{ $song["artist"] }}</p>
</div>
@endforeach