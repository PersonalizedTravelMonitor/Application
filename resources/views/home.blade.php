@extends('layouts.app')

@section('content')
  Welcome, {{ Auth::user()->name }} ({{ Auth::user()->email }})<br>

  {{-- Auth::user() is the logged-in user --}}
  @if (Auth::user()->isAdmin)
    <h1>You are Admin!</h1>
  @endif

  <button class="button" onclick="enableNotifications()">Register for notifications</button>

  <h2 class="is-size-2">Your Trips</h2>
  <a class="is-size-4" href="{{ route('trips.create') }}">Create a trip</a>
  <br>
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
          <b>On days:</b>
          @foreach($trip->repeatingOn as $day)
            {{-- This will get the next $day date and only print the day of the week name, "Monday" for example --}}
            {{ \Carbon\Carbon::now()->next($day)->format('l') }}
          @endforeach
          <br><br>

          <b>With parts:</b> <br>
          <ul>
          @forelse($trip->parts as $part)
            <li>
              <b>{{ $part->from }} - {{ $part->to }}:</b>
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
    No Trips :(
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
@endsection

@section('scripts')
<script>
var _registration = null;
function registerServiceWorker() {
  return navigator.serviceWorker.register('js/service-worker.js')
  .then(function(registration) {
    console.log('Service worker successfully registered.');
    _registration = registration;
    return registration;
  })
  .catch(function(err) {
    console.error('Unable to register service worker.', err);
  });
}

function askPermission() {
  return new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  })
  .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('We weren\'t granted permission.');
    }
    else{
      subscribeUserToPush();
    }
  });
}

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function getSWRegistration(){
  var promise = new Promise(function(resolve, reject) {
  // do a thing, possibly async, then…

  if (_registration != null) {
    resolve(_registration);
  }
  else {
    reject(Error("It broke"));
  }
  });
  return promise;
}

function subscribeUserToPush() {
  getSWRegistration()
  .then(function(registration) {
    console.log(registration);
    const subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(
        "{{env('VAPID_PUBLIC_KEY')}}"
      )
    };

    return registration.pushManager.subscribe(subscribeOptions);
  })
  .then(function(pushSubscription) {
    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
    sendSubscriptionToBackEnd(pushSubscription);
    return pushSubscription;
  });
}

function sendSubscriptionToBackEnd(subscription) {
  return fetch('/api/save-subscription/{{Auth::user()->id}}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(subscription)
  })
  .then(function(response) {
    if (!response.ok) {
      throw new Error('Bad status code from server.');
    }

    return response.json();
  })
  .then(function(responseData) {
    if (!(responseData && responseData.success)) {
      throw new Error('Bad response from server.');
    }
  });
}

function enableNotifications(){
  //register service worker
  //check permission for notification/ask
  askPermission();
}
registerServiceWorker();
</script>
@endsection
