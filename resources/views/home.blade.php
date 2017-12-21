@extends('layouts.app')

@section('content')
    You are logged in!
    {{ Auth::user()->email }} <br>

    {{-- Auth::user() is the logged-in user --}}
    @if (Auth::user()->isAdmin)
        <h1>Sei Admin!</h1>
    @endif

    <h2 class="is-size-2">Your Trips</h2>
    @forelse(Auth::user()->trips as $trip)
        <div class="card">
            <div class="card-content">
                <p class="title">
                    Trip
                </p>
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
            </div>
        <br>
    @empty
        No Trips :(    
    @endforelse
    
    <h2 class="is-size-2">Your Statistics</h2>
            @foreach(Auth::user()->personalStatistic as $stats)
                 
                    <div class="card">
                        <div class="card-content">
                            <p class="title">
                                Statistic <code>  {{$stats->month}}/{{$stats->year}} </code>
                            </p>
                            <p class="subtitle">
                                <code>{{$stats}}</code>
                            </p>
                        </div>
                    </div>
                    <br>
            @endforeach
@endsection
