@foreach($playlist as $playyy)
    <h1>Overview playlist#{{ $playyy["playlist_id"] }}</h1>
    <h4>Name:</h4>
    <p>{{ $playyy["playlist_name"] }}</p>
    <h4>Duration:</h4>
    <p>{{ $playyy["playlist_duration"] }}</p>
@endforeach