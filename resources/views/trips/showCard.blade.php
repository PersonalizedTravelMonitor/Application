<div class="card">
  @if ($showHeader)
    <div class="card-header">
      <div class="card-header-title">{{ $number+1 }}.</span> From {{ $part->from }} to {{ $part->to }}</div>
    </div>
  @endif
  <div class="card-content content">
    @switch($part->details_type)
      @case("App\TrenordTripPart")
        - On <b>Train {{ $part->details->trainId }}</b> ({{ $part->details->departure }} -> {{ $part->details->arrival }})
        @break
    @endswitch
    <br>
    <br>
    <b class="is-size-4">Events:</b>
    <ul>
      @forelse($part->getEventsForDate($date) as $event)
        <li>
          {!! $event->details->toHTML() !!}
          @if((Auth::user()->isAdmin)&&($event->details->message!=[])) 
            <span class="has-text-right" >
            <a href="{{ route('tripParts.removeTravelerReportEvent', [$trip, $part, $event]) }}" >
              <i class="fas fa-trash-alt has-text-danger"></i>
            </a>
          </span>
          @endif
        </li>
      @empty
        No events for this trip part
      @endforelse
    </ul>
    @if ($showUserReport)
      @auth
        <hr>
        <b class="is-size-5">Create user report</b><br><br>
        <form action="{{ route('tripParts.addTravelerReportEvent', [$trip, $part]) }}" method="POST">
          {{ csrf_field() }}
            <div class="columns">
              <div class="column">
                <input class="input" name="message"
                  type="text"
                    @if ($part->is_checked)
                      placeholder="Can't add a report for a trip that has already concluded"
                    @else
                      placeholder="Your report"
                    @endif
                  required
                  @if ($part->is_checked)
                    disabled
                  @endif
                >
              </div>
              <div class="column is-narrow">
                <button type="submit" class="button is-dark"
                  @if ($part->is_checked)
                    disabled
                  @endif
                  >Submit</button>
              </div>
            </div>
        </form>
      @endauth
    @endif
  </div>
</div>
<br>
