@extends('layouts.app')

@section('content')
<span align="center"><h1 class="title is-4">Your trip from {{ $trip->from() }} to {{ $trip->to() }}</h1></span>

@if ($trip->orderedParts->count() > 1)
  <br>
  <span align="center"><b>Your trip consists of {{$trip->orderedParts->count()}} parts:</b></span>
  <br>
@endif
<div class="columns is-multiline is-centered">
@forelse($trip->orderedParts as $part)
<div class="column is-half">
  {{ $part->internalTrainId }}
  @include('trips.showCard', [
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
    'part' => $part,
    'showHeader' => ($trip->orderedParts->count() > 0),
    'showUserReport' => false,
    'date' => \Carbon\Carbon::yesterday()
  ])
@empty
  This should never happen
@endforelse
@endsection
