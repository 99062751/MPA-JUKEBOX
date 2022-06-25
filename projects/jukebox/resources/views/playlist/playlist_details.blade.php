@foreach($playlist as $play)
    <h1>Name playlist:</h1>
    <p>{{ $play["name"] }}</p>
    <h1>Songs playlist:</h1>
    @foreach($play["songs"] as $s)
    <p>{{ $s }}</p>
    @endforeach
    <h1>Duration playlist:</h1>
    <p>{{ $play["duration"] }}</p>
@endforeach