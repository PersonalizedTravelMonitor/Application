@extends('layouts.app')

@section('content')
<h1 class="title is-4 has-text-centered">Here your trip from {{ $trip->from() }} to {{ $trip->to() }}</h1>

@if ($trip->orderedParts->count() > 1)
  <br>
  <div><b class="has-text-centered">Your trip consists of {{$trip->orderedParts->count()}} parts:</b></div>
  <br>
@endif
<div class="columns is-multiline is-centered">
@forelse($trip->orderedParts as $part)
<div class="column is-half">
  {{ $part->internalTrainId }}
  @include('trips.showCard', [
    'number' => $loop->index,
    'part' => $part,
    'showHeader' => ($trip->orderedParts->count() > 0),
    'showUserReport' => true,
    'date' => \Carbon\Carbon::today()
  ])
  </div>
@empty
  This should never happen
@endforelse
</div>

<hr>
<h2 class="title is-4">Yesterday Report</h2>
@forelse($trip->orderedParts as $part)
  @include('trips.showCard', [
    'number' => $loop->index,
    'part' => $part,
    'showHeader' => ($trip->orderedParts->count() > 0),
    'showUserReport' => false,
    'date' => \Carbon\Carbon::yesterday()
  ])
@empty
  This should never happen
@endforelse
@endsection
