    @if (Auth::check())
    {{ var_dump($arr)}}
    @else
    @foreach($playlist as $play)
    <h1>Naam playlist: "{{$play["name"]}}"</h1>
    <h2>Songs:</h2>
    <div style="width: 1400px; display: inline-flex;">
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
    </div>

    <form action="{{ route('playlist.addsongsto.playlist', $play['name']) }}">
        <label for="">Add more songs</label><br>
        <select name="songstoadd[]" id="" multiple size="2">
            @foreach ($select_songs as $select_song)
                <option value="{{$select_song->id}}">{{$select_song->name}}</option>
            @endforeach
        </select><br>
        <input type="submit" value="Add">
    </form>
    
    <h2>
        Duur (min/sec): {{$play["duration"]}}
    </h2>
    @endforeach
    <!-- {{ var_dump($songs)}} -->
    @endif

