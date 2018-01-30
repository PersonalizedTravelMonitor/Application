@extends('layouts.app')

@section('content')
<h1 class="title is-3">{{ $trip->from() }} - {{ $trip->to() }}</h1>

<br>

With parts: <br>
@forelse($trip->orderedParts as $part)
  <div class="card">
    <div class="card-header">
      <div class="card-header-title">{{ $part->from }} - {{ $part->to }} ({{ $part->details_type }})</div>
    </div>
    <div class="card-content content">
      @switch($part->details_type)
        @case("App\TrenordTripPart")
          Train {{ $part->details->trainId }}
          @break
        @case("App\TrenitaliaTripPart")
          {{ $part->details->trainId }}
          @break
        @case("App\AtmTripPart")
          {{ $part->details->vehicleType }}
          @break
      @endswitch
      <br>
      <b>Events</b>
      <ul>
      @forelse($part->todayEvents as $event)
        <li>
          {!! $event->details->toHTML() !!}
        </li>
      @empty
        No events for this trip part
      @endforelse
      </ul>
      <br>

      @auth
        <b>Create user reports</b>
        <form action="{{ route('tripParts.addTravelerReportEvent', [$trip, $part]) }}" method="POST">
          {{ csrf_field() }}
            <div class="columns">
              <div class="column">
                <input class="input" name="message" type="text" placeholder="Your report">
              </div>
              <div class="column is-narrow">
                <button type="submit" class="button is-dark">Submit</button>
              </div>
            </div>
        </form>
      @endauth

    </div>
  </div>
  <br>
@empty
  This should never happen
@endforelse
@endsection
