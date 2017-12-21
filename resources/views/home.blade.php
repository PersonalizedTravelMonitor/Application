@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    {{ Auth::user()->email }} <br>

                    {{-- Auth::user() is the logged-in user --}}
                    @if (Auth::user()->isAdmin)
                        <h1>Sei Admin!</h1>
                    @endif
                    
                    <h2>Your trips</h2>
                    @forelse(Auth::user()->trips as $trip)
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
                        <br>
                        <hr>
                    @empty
                        No Trips :(
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
