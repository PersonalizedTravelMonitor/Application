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
      <div class="card-header">
        <div class="level">
          <a href="{{ route('trips.show', $trip) }}" class="level-item card-header-title">{{ $trip->from() }} - {{ $trip->to() }}</a>
          <div class="level-item">
            <a href="{{ route('trips.show', $trip) }}" class="button is-small">Details</a>
          </div>
        </div>
      </div>
      <div class="card-content">
        On days:
        @foreach($trip->repeatingOn as $day)
          {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
          {{ \Carbon\Carbon::now()->next($day)->format('l') }}
        @endforeach
        <br>

        With parts: <br>
        <ul>
          @forelse($trip->parts as $part)
            <li>
              {{ $part->from }} - {{ $part->to }} ({{ $part->details_type }}):
              @php
              switch ($part->details_type) {
              case "App\TrenordTripPart":
                echo $part->details->trainId;
                break;
              case "App\TrenitaliaTripPart":
                echo $part->details->trainId;
                break;
              case "App\AtmTripPart":
                echo $part->details->vehicleType;
                break;
              }
              @endphp
            </li>
          @empty
            <li>This should never happen</li>
          @endforelse
        </ul>
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
