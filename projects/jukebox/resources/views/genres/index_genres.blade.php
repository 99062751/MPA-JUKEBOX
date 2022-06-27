
@foreach($genres as $genre)
<div>
    <h1>{{ $genre->name }}</h1>
    <p>{{ $genre->description }}</p>
    <a href="{{ route('songs.overview', $genre->id) }}">View songs</a>
</div>


@endforeach