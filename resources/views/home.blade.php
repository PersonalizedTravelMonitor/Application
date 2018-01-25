@extends('layouts.app')

@section('content')
  Welcome, {{ Auth::user()->name }} ({{ Auth::user()->email }})<br>

  {{-- Auth::user() is the logged-in user --}}
  @if (Auth::user()->isAdmin)
    <h1>You are Admin!</h1>
  @endif

  <h2 class="is-size-2">Your Trips</h2>
  <a class="is-size-4" href="{{ route('trips.create') }}">Create a trip</a>
  <br>
  <div class="columns is-multiline is-centered">
  @forelse(Auth::user()->trips as $trip)
    <div class="column is-half">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
          <span class="icon is-small"><i class="fa fa-train"></i></span>
          <a href="{{ route('trips.show', $trip) }}" class="level-item card-header-title">{{ $trip->from() }} - {{ $trip->to() }}</a>
          </p>
          <a href="#" class="card-header-icon" aria-label="more options">
            <span class="icon">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </a>
        </header>
        <div class="card-content">
          <div class="content">
          <b>On days:</b>
          @foreach($trip->repeatingOn as $day)
            {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
            {{ \Carbon\Carbon::now()->next($day)->format('l') }}
          @endforeach
          <br><br>

          <b>With parts:</b> <br>
          <ul>
          @forelse($trip->parts as $part)
            <li>
              <b>{{ $part->from }} - {{ $part->to }}:</b>
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
        <footer class="card-footer">
          <a href="{{ route('trips.show', $trip) }}" class="card-footer-item">Details</a>
        </footer>
      </div>
    </div>
    @empty
    No Trips :(
  @endforelse
  </div>

<hr>

  <h2 class="is-size-2">Your Statistics</h2><br><br>
  <div class="columns is-multiline is-centered">
  @foreach(Auth::user()->personalStatistic as $stats)
  <div class="column is-half">
      <div class="card">
      <header class="card-header">
        <p class="card-header-title">
        <span class="icon is-small"><i class="fas fa-info-circle"></i></span>
            Statistics for {{ $stats->month }}/{{ $stats->year }}
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
          <span class="icon">
            <i class="fas fa-angle-down" aria-hidden="true"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
        <b>Minutes of Delay: </b>{{ $stats->minutesOfDelay}} <br>
        <b>Number Of Severe Disruption: </b>{{ $stats->numberOfSevereDisruption}}
        </div>
        </div>
      <footer class="card-footer">
        <a href="#" class="card-footer-item">Più informazioni</a>
      </footer>
    </div>
    </div>



  @endforeach
@endsection
