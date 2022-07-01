    {{-- ALS HIJ INGELOGD IS --}}
    <body style="background-color: black; color: grey;"> 
        @if (Auth::check())
            <h1>"{{$playlist->name}}"</h1>
            <h2>Songs:</h2>
            <div style="width: 1400px; display: inline-flex;">
                @foreach($songs as $index => $song)
                <div style="background-color: grey; width: 300px; color: white; padding: 12px; margin: 13px;">
                    <h3>Naam: {{ $song->name }}</h3>
                    <h3>Artiest: {{ $song->artist }}</h5>
                    @if($song->duration <= 60)
                        <h3>Duur (min/sec): {{ date("H:i:s", strtotime($song->duration)) }}</h3>
                    @else
                        <h3>Duur (min/sec): {{ date("i:s", strtotime($song->duration)) }}</h3>
                    @endif
                    <form action="{{ route('retrieveSong.playlist', $playlist->id) }}">
                        <input type="hidden" name="song_id" value="{{$song->id}}">
                        <input type="submit" value="Delete Song">
                    </form>
                </div>
                @endforeach
            </div>

            <form action="{{ route('addSong.playlist', $playlist->id) }}">
                <label for="">Add more songs</label><br>
                <select name="songstoadd[]" id="" multiple size="2">
                    @foreach ($select_songs as $select_song)
                        <option value="{{$select_song->id}}">{{$select_song->name}}</option>
                    @endforeach
                </select><br>
                <input type="hidden" value="{{$song->id}}" name="song_id">
                <input type="submit" value="Add">
            </form>

            <h2>
                Duur (min/sec): {{$playlist->duration}}
            </h2>

            <h2>Wijzig naam</h2>
            <form action="{{ route('playlist.details.save', $playlist->id) }}">
                <label for="play_name">Naam playlist:</label><br>
                <input type="text" name="play_name" value="{{ $playlist->name }}"><br>
                <input type="submit" value="Save name">
            </form>


            {{-- ALS HIJ NIET INGELOGD IS --}}

            @else
            <h1>Naam playlist: "{{$playlist["name"]}}"</h1>
            <h2>Songs:</h2>
            <div style="width: 1400px; display: inline-flex;">
                @foreach($songs as $index => $song)
                <div style="background-color: grey; width: 300px; color: white; padding: 12px; margin: 13px;">
                    <h3>Naam: {{ $song->name }}</h3>
                    <h3>Artiest: {{ $song->artist }}</h5>
                    @if(strtotime($song->duration) <= 60)
                        <h3>Duur (min/sec): {{ date("H:i:s", strtotime($song->duration)) }}</h3>
                    @else
                        <h3>Duur (min/sec): {{ date("i:s", strtotime($song->duration)) }}</h3>
                    @endif
                    <form action="{{ route('retrieveSong.session', $playlist['name']) }}">
                        <input type="hidden" name="song_id" value="{{$index}}">
                        <input type="submit" value="Delete Song">
                    </form>
                </div>
                @endforeach
            </div>

            <form action="{{ route('addSong.session', $playlist['name']) }}">
                <label for="">Add more songs</label><br>
                <select name="songstoadd[]" id="" multiple size="2">
                    @foreach ($select_songs as $select_song)
                        <option value="{{$select_song->id}}">{{$select_song->name}}</option>
                    @endforeach
                </select><br>
                
                <input type="submit" value="Add">
            </form>
            
            <h2>
                Duur (min/sec): {{$playlist["duration"]}}
            </h2>

            {{-- <h2>Wijzig naam</h2>
            <form action="{{ route('playlist.details.save', $playlist['name']) }}">
                <label for="play_name">Naam playlist:</label><br>
                <input type="text" name="play_name" value="{{ $playlist['name'] }}"><br>
                <input type="hidden" name="songs" value="{{ $songs }}">
                <input type="submit" value="Save name">
            </form> --}}
        @endif
    </body>
    