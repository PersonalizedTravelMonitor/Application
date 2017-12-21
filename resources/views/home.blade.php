@extends('layouts.app')

@section('content')
  Welcome, {{ Auth::user()->email }} <br>

  {{-- Auth::user() is the logged-in user --}}
  @if (Auth::user()->isAdmin)
    <h1>You are Admin!</h1>
  @endif

  <h2 class="is-size-2">Your Trips</h2>
  @forelse(Auth::user()->trips as $trip)
    <div class="card">
      <div class="card-content">
        <p class="title">
            Trip {{ $trip->from() }} - {{ $trip->to() }}
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
            Statistics for {{ $stats->month }}/{{ $stats->year }}
          </p>
          <p class="subtitle">
            <code>{{ $stats }}</code>
          </p>
        </div>
      </div>
    @endforeach
@endsection
