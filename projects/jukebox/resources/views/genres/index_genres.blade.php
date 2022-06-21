
@foreach($genres as $genre)
<div>
    <h1>{{ $genre["genre_name"] }}</h1>
    <p>{{ $genre["genre_desc"] }}</p>
    <a href="{{ route('songs.overview', $genre['genre_id']) }}">View songs</a>
</div>
@endforeach