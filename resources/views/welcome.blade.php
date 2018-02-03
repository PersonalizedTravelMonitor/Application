@extends('layouts.app')

@section('content')
<section class="hero">
  <div class="hero-body">
    <div class="container has-text-centered">
      <div class="columns is-vcentered">
        <div class="column is-5">
          <figure class="image">
            <img src="{{ asset('img/logoHome.svg') }}" alt="Description">
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
            <a href="{{route('register')}}" class="button is-medium is-info is-outlined">
            <span>Join Now</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
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
      <p>Write and read reports of other users for your scheduled trip. You will never lose any information about your trip!</p>
    </div>
  </div>
</div>
<br><br>
<div class="has-text-centered">
  <h4 class="is-size-4">Evolution of the source code</h4>
  <video style="width:50%" controls>
    <source src="{{ asset('video/output.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</div>
@endsection
