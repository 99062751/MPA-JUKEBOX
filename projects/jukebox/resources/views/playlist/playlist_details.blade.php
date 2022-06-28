    @if (Auth::check())
    {{ var_dump($arr)}}
    @else
    @foreach($playlist as $play)
    <h1>Naam playlist: "{{$play["name"]}}"</h1>
    <h2>Songs:</h2>
        @foreach($songs as $song)
        <div style="background-color: grey; width: 300px; color: white; padding: 12px; margin: 13px;">
            <h3>Naam: {{ $song->name }}</h3>
            <h3>Artiest: {{ $song->artist }}</h5>
            @if(date("i", strtotime($song->duration)) <= 60)
                <h3>Duur (min/sec): {{ date("i:s", strtotime($song->duration)) }}</h3>
            @else
                <h3>Duur (min/sec): {{ date("h:i:s", strtotime($song->duration)) }}</h3>
            @endif
        </div>
        @endforeach
    <h2>
        Duur (min/sec): {{$play["duration"]}}
    </h2>
    @endforeach
    <!-- {{ var_dump($songs)}} -->
    @endif

