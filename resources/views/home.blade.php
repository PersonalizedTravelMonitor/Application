@extends('layouts.app')

@section('content')
    You are logged in!
    {{ Auth::user()->email }} <br>

    {{-- Auth::user() is the logged-in user --}}
    @if (Auth::user()->isAdmin)
        <h1>Sei Admin!</h1>
    @endif

    <h2 class="is-size-4">Your trips</h2>
    @forelse(Auth::user()->trips as $trip)

        <div class="box">
            <code>{{ $trip }}</code>
            On days: 
            @foreach($trip->repeatingOn as $day)
                {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
                {{ \Carbon\Carbon::now()->next($day)->format('l') }}
            @endforeach
            <br><br>     
            With parts: <br>
            @forelse($trip->parts as $part)
                <code>{{ $part }}</code>
                @if ($part->child_type == "TrenordTripPart")
                    {{ $part->details->trainId }} 
                @endif
            @empty
                <b>This should never happen</b>
            @endforelse
        </div>
    @empty
        No Trips :(
    @endforelse

    <h2>Your statistics</h2>
    @foreach(Auth::user()->personalStatistic as $stats)
        <code>
            <b>{{ $stats->year }}/{{ $stats->month }}</b> <br>
            {{ $stats }} <hr>
        </code>
        
        <br>
    @endforeach
@endsection
