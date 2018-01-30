@extends('layouts.app')

@section('content')
  <div class="columns">
    <div class="column">
      Welcome, <b>{{ Auth::user()->name }}</b>!
    </div>
    <div class="column is-narrow">
      <button class="button" style="display:none;" id="notifications-button" onclick="enableNotifications()">Register for notifications</button>
    </div>
  </div>
  </p>
  <hr>
  <div class="columns is-vcentered">
    <div class="column">
      <h2 class="is-size-2">Your Trips</h2>
    </div>
    <div class="column is-narrow">
      <a href="{{ route("trips.create") }}" class="button is-success is-medium">
        <span class="icon">
          <i class="fas fa-plus"></i>
        </span>
        <span>Follow a new trip</span>
      </a>
    </div>
  </div>


  <article id="subscribed-trip-section" style="display:none" class="message is-success">
    <div class="message-header">
      <p>Success</p>
      <button class="delete" aria-label="delete" id="delete-message"></button>
    </div>
    <div>
      <span id="subscribed-correctly"></span>
  </div>
  </article>


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
          @if($trip->repeatingOn!=[])
            <b>On days:</b>
            @foreach($trip->repeatingOn as $day)
              {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
              {{ \Carbon\Carbon::now()->next($day)->format('l') }}
            @endforeach
            <br><br>
          @endif


          <b>With parts:</b> <br>
          <ul>
          @forelse($trip->orderedParts as $part)
            <li>
              <b>{{ $part->from }} - {{ $part->to }}:</b>
              @switch ($part->details_type)
                @case("App\TrenordTripPart")
                  Train {{ $part->details->trainId }} @ {{ $part->details->departure }}
                  @break
              @endswitch
            </li>
          @empty
            <li>This should never happen</li>
          @endforelse
          </ul>
          </div>
        </div>
        <footer class="card-footer">
          <a href="{{ route('trips.show', $trip) }}" class="card-footer-item">Details</a>
          <form method="POST" action="{{ route('trips.destroy', $trip) }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input type="submit" class="card-footer-item" value="Delete">
          </form>
        </footer>
      </div>
    </div>
    @empty
    No Trips Seected
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
  </div>
  <hr>
  <h2 class="is-size-2">Announcements</h2>
  @forelse(\App\Announcement::orderBy('created_at', 'desc')->get() as $announcement)
    <article class="message is-light">
      <div class="message-header">
        <p>{{ $announcement->title }}</p>
      </div>
      <div class="message-body">
        {{ $announcement->text }}
      </div>
    </article>
  @empty
    <p>No recent announcements from the Admins to show</p>
  @endforelse
  <script type="text/javascript">
  if(sessionStorage.getItem("inserted")){
    sessionStorage.removeItem("inserted");
    $("#subscribed-trip-section").show();
    $("#subscribed-correctly").text(sessionStorage.getItem("message"));
    sessionStorage.removeItem("message");
    $("#delete-message").click(function(){
      $("#subscribed-trip-section").hide();
    });


  }
</script>
@endsection

@section('scripts')
  @auth
    <script>
      VAPID_PUBLIC_KEY = "{{env('VAPID_PUBLIC_KEY')}}"
    </script>
    <script src="{{ asset('/js/notifications.js')}}"></script>
  @endauth
@endsection
