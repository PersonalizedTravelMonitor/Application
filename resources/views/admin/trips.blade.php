@extends('layouts.app')

@section('content')
  <h2 class="is-size-3">{{ \App\Trip::count() }} Trips registered on the system</h2>
  <div class="content">
    <ul>
      @foreach(\App\Trip::all() as $trip)
        <li><a href="{{ route('trips.show', $trip) }}" target="_blank">From {{ $trip->from() }} to {{ $trip->to() }}</a> by <b>{{ $trip->user->name }}</b>. Parts:
          <ul>
            @foreach($trip->parts as $part)
              <li>{{ $part->from }} - {{ $part->to }}</li>
            @endforeach
          </ul>
        </li>
      @endforeach
    </ul>
  </div>
@endsection
