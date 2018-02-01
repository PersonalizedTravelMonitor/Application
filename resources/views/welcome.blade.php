@extends('layouts.app')

@section('content')
<div class="hero-body">
  <div class="container has-text-centered">
    <div class="columns is-vcentered">
      <div class="column is-5">
        <figure class="image is-4by3">
          <img src="{{ asset('img/logoHome.png') }}" alt="Description">
        </figure>
      </div>
      <div class="column is-6 is-offset-1">
        <h1 class="title is-2">
          Personalized Travel Monitor
        </h1>
        <h2 class="subtitle is-4">
          Follow your trips, get notified and stay up to date!
        </h2>
        <br>
        <p class="has-text-centered">
          <a href="#LearnMore" class="button is-medium is-info is-outlined">
          <span>Learn More</span>
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
<hr>
<br><br>
<a name="LearnMore"></a>
<div class="container">
  <div class="columns has-text-centered">
    <div class="column">
      <span class="icon">
        <i class="fas fa-train fa-5x"></i>
      </span>
      <h3 class="is-size-3">Follow Trips</h3>
      <p>Search for your usual trip and schedule it on the days you want!</p>
    </div>
    <div class="column">
      <span class="icon"><i class="fas fa-bell fa-5x"></i></span>
      <h3 class="is-size-3">Get Notified</h3>
      <p>Receive notifications about delays, modifications or alerts for your programmed trips!</p>
    </div>
    <div class="column">
      <span class="icon"><i class="fas fa-clock fa-5x"></i></span>
      <h3 class="is-size-3">Stay up to date</h3>
      <p>Write and read the report of other users for your schedules. You will never lose any information about your trip!</p>
    </div>
  </div>
</div>
</section>
@endsection
