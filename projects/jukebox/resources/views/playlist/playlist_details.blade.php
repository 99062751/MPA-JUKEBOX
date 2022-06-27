@if (Auth::check())

@else
{{ var_dump($playlist[0]["songs"])}}
@endif