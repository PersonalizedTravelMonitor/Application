@extends('layouts.app')

@section('content')
  <h1 class="title" align="center">Admin Panel</h1>
  <h2 class="is-size-3">Overview</h2>
  <div class="columns">
    <div class="column">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            Users
          </p>
        </header>
        <div class="card-content">
          <div class="content">
            There are <b>{{ $nUsers }} registered users</b>
          </div>
        </div>
        <footer class="card-footer">
          <a href="#" class="card-footer-item">Show</a>
        </footer>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            Trips
          </p>
        </header>
        <div class="card-content">
          <div class="content">
            There are <b>{{ $nTrips }} registered trips</b> with <b>{{ $nParts }} trip parts</b> in total
          </div>
        </div>
        <footer class="card-footer">
          <a href="#" class="card-footer-item">Show</a>
        </footer>
      </div>
    </div>
  </div>

  <h2 class="is-size-3">Announcements</h2>
  <form action="{{ route('admin.announcement') }}" method="POST">
    {{ csrf_field() }}
    <div class="field">
      <label class="label">Title:</label>
      <div class="control">
        <input name="title" class="input is-fullwidth"placeholder="Type the title">
      </div>
    </div>
    <div class="field">
      <label class="label">Text:</label>
      <div class="control">
        <textarea name="text" class="textarea" placeholder="Type the global announcement here"></textarea>
      </div>
    </div>
    <div class="field">
      <div class="control">
        <button class="button is-danger is-fullwidth">Send</button>
      </div>
    </div>
  </form>
@endsection
