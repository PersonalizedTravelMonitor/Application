@extends('layouts.app')

@section('content')
  <div class="columns">
    <div class="column">
      <h1 class="title is-2 has-text-centered">Dashboard</h1>
      <h2 class="subtitle has-text-centered">Personalized Travel Monitor</h2>
      <h2 class="subtitle is-6">Welcome, <b>{{ Auth::user()->name }}</b>!</h2>
    </div>
    <div class="column is-narrow">
      <button class="button" style="display:none;" id="notifications-button" onclick="enableNotifications()">Register for notifications</button>
    </div>
  </div>
  </p>
  <hr>
  <div class="columns is-centered">
    <div class="column">
      <h2 class="is-size-2 has-text-left">
        <i class="fas fa-flag-checkered"></i>&nbsp;
        <span>Your Trips</span>
      </h2>
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
  <div class="notification is-light">
      Here you find the trips you are following.
      You can view details or delete them.
  </div>


  <article id="subscribed-trip-section" style="display:none" class="message is-success">
    <div class="message-header">
      <p>
        <i class="fas fa-check"></i>&nbsp;
        Success
      </p>
      <button class="delete" aria-label="delete" id="delete-message"></button>
    </div>
    <div class="message-body">
      <span id="subscribed-correctly"></span>
  </div>
  </article>


  <div class="columns is-multiline is-centered">
  @forelse(Auth::user()->trips as $trip)
    <div class="column is-half">
      <div class="card" style="display:flex; flex-direction:column; height:100%;
        @if(!$trip->isActiveToday())
          opacity:0.5;
        @endif
      ">
        <header class="card-header">
          <p class="card-header-title">
          <span class="icon is-small"><i class="fa fa-train"></i></span>
          <a href="{{ route('trips.show', $trip) }}" class="level-item card-header-title">
            {{ $trip->from() }} - {{ $trip->to() }}
            @if(!$trip->isActiveToday())
              (Not followed for this weekday)
            @endif
          </a>
          </p>
        </header>
        <div class="card-content" style="flex:1;">
          <div class="content">
          @if($trip->repeatingOn!=[])
            <b>On days:</b>
            @foreach($trip->repeatingOn as $day)
              {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
              {{ \Carbon\Carbon::now()->next($day)->format('l') }}
              @if(!$loop->last)
              -
              @endif
            @endforeach

          @else
          <b>Just for today</b>
          @endif
          <br><br>

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
              @if ($part->todayEvents->count() > 0)
                <ul>
                  <li>
                    {!! $part->latestEvent()->details->toHTML() !!}
                  </li>
                </ul>
              @else
                @if ($trip->isActiveToday())
                  @if (\Carbon\Carbon::createFromFormat('H:i:s', $part->details->departure)->diffInMinutes(\Carbon\Carbon::now(), false) > 15)
                    <p>There are no updates on your trip, even if it should have already departed, maybe something is wrong with the Provider API</p>
                  @endif
                @endif
              @endif
            </li>
          @empty
            <li>This should never happen</li>
          @endforelse
          </ul>
          </div>
        </div>
        <footer class="card-footer">
          <a href="{{ route('trips.show', $trip) }}" class="card-footer-item">Details</a>
          <div class="card-footer-item">
            <form method="POST" action="{{ route('trips.destroy', $trip) }}">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <input type="submit" class="button is-danger is-inverted" value="Delete">
            </form>
          </div>
        </footer>
      </div>
    </div>
    @empty
    No Trips Followed
  @endforelse
  </div>


  <hr>

  <h2 class="is-size-2">
      <i class="fas fa-bullhorn"></i> &nbsp;
    <span>Announcements</span>
  </h2>
  <br>
  <div class="notification is-light">
  Here you can find the announcements of the lines you are following.
  </div>
  <div class="columns is-multiline is-centered">
  @forelse(\App\Announcement::orderBy('created_at', 'desc')->get() as $announcement)
    <div class="column is-half">
    <article class="message">
      <div class="message-header">

        <p>{{ $announcement->title }}</p>
        <span align="left">{{ $announcement->created_at->format('d/m/Y H:i') }}
        </span>

      </div>

      <div class="message-body">
        {{ $announcement->text }}
        <br>
        @if(Auth::user()->isAdmin)
        <div class="has-text-right">
          <a href="{{ route('admin.deleteAnnouncement', $announcement) }}" >
            <i class="fas fa-trash-alt"></i>
          </a>
        </div>
      @endif
      </div>
      </div>
    </article>
  @empty
  <div class="has-text-centered">
    <p>No recent announcements from the Admins to show</p>
  </div>
  @endforelse
  </div>

  <hr>

  <h2 class="is-size-2">
      <i class="fas fa-chart-bar"></i>&nbsp;
      <span>Your Statistics</span>
  </h2>
  <br>
  <div class="notification is-light">
    Here you can find your monthly statistics of the trips you are following.
  </div>
  <div class="columns is-multiline is-centered">
    @foreach(Auth::user()->personalStatistic as $stats)
    <div class="column is-half">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
              <i class="fas fa-info-circle"></i>&nbsp;
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
          <a href="#" class="card-footer-item">More info</a>
        </footer>
      </div>
    </div>
    @endforeach
    <div class="columns">
      <div class="column">Number of events on your trips: {{ $eventsCount }}</div>
    </div>
  </div>
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
