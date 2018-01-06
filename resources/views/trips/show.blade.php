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
      <br>
      <b>Events</b>
      @forelse($part->events as $event)
        <code>{{ $event }}</code>
        <code>{{ $event->details }}</code>
      @empty
        No events for this trip part
      @endforelse

      @auth
        <form action="{{ route('tripParts.addTravelerReportEvent', $part) }}" method="POST">
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
