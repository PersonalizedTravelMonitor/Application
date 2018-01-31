<div class="card">
  @if ($showHeader)
    <div class="card-header">
      <div class="card-header-title">{{ $number+1 }}.</span> From {{ $part->from }} to {{ $part->to }}</div>
    </div>
  @endif
  <div class="card-content content">
    @switch($part->details_type)
      @case("App\TrenordTripPart")
        On <b>Train {{ $part->details->trainId }}</b>
        @break
    @endswitch
    <br>
    <br>
    <b class="is-size-4">Events:</b>
    <ul>
      @forelse($part->getEventsForDate($date) as $event)
        <li>
          {!! $event->details->toHTML() !!}
        </li>
      @empty
        No events for this trip part
      @endforelse
    </ul>
    @if ($showUserReport)
      @auth
        <br>
        <b class="is-size-5">Create user report</b>
        <form action="{{ route('tripParts.addTravelerReportEvent', [$trip, $part]) }}" method="POST">
          {{ csrf_field() }}
            <div class="columns">
              <div class="column">
                <input class="input" name="message" type="text" placeholder="Your report" required>
              </div>
              <div class="column is-narrow">
                <button type="submit" class="button is-dark">Submit</button>
              </div>
            </div>
        </form>
      @endauth
    @endif
  </div>
</div>
<br>
