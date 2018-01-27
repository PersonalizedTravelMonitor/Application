@extends('layouts.app')

@section('content')
<h1 class="title is-3">{{ $trip->from() }} - {{ $trip->to() }}</h1>

<br>

With parts: <br>
@forelse($trip->parts as $part)
  <div class="card">
    <div class="card-header">
      <div class="card-header-title">{{ $part->from }} - {{ $part->to }} ({{ $part->details_type }})</div>
    </div>
    <div class="card-content">
      @switch($part->details_type)
        @case("App\TrenordTripPart")
          {{ $part->details->trainId }}
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
      @forelse($part->events as $event)
        <div>
          <i>{{ $event->details_type }}</i>
          @switch($event->details_type)
            @case("App\TravelerReportEvent")
              <b>{{ $event->details->author->name }}</b>: {{ $event->details->message }}
              @break
            @case("App\DelayEvent")
              <b>{{ $event->details->station }}</b>: Delay of {{ $event->details->amount }} minutes
              @break
          @endswitch
        </div>
      @empty
        No events for this trip part
      @endforelse

      @auth
        <form action="{{ route('tripParts.addTravelerReportEvent', [$trip, $part]) }}" method="POST">
          {{ csrf_field() }}
          <input type="text" name="message" placeholder="Your report">
          <input type="submit" value="Send user report">
        </form>
      @endauth
    </div>
  </div>
  <br>
@empty
  This should never happen
@endforelse
@endsection
