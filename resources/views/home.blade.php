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

                    @foreach(Auth::user()->trips as $trip)
                        <code>
                            {{ $trip }}
                        </code>
                        On days: 
                        @foreach($trip->repeatingOn as $day)
                            {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
                            {{ \Carbon\Carbon::now()->next($day)->format('l') }}
                        @endforeach
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
