@extends('layouts.app')

@section('content')
<h1 class="title is-3">Your trip from {{ $trip->from() }} to {{ $trip->to() }}</h1>

@if ($trip->orderedParts->count() > 1)
  <br>
  <b>With parts:</b>
  <br>
@endif

@forelse($trip->orderedParts as $part)
  @include('trips.showCard', [
    'part' => $part,
    'showHeader' => ($trip->orderedParts->count() > 0),
    'showUserReport' => true,
    'date' => \Carbon\Carbon::today()
  ])
@empty
  This should never happen
@endforelse

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
