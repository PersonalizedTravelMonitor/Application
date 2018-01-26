@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
<div class="container has-text-centered">
  <div class="column is-4 is-offset-4">
    <h3 class="title has-text-grey">Register</h3>
    <p class="subtitle has-text-grey">Please register to proceed.</p>
    <div class="box">
      <figure class="avatar">
        <img src="https://placehold.it/128x128">
      </figure>
      <form method="POST" action={{ route('register') }}>
        {{csrf_field() }}
        <div class="field">
          <div class="control">
            <input class="input" name="name" value="{{old('name') }}" id="name" type="text" placeholder="Your Name" autofocus="" required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" name="email" value="{{old('email') }}" id="email" type="email" placeholder="Your Email" autofocus="" required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" name="password" id="password" type="password" placeholder="Your Password" required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Your Password" required>
          </div>
        </div>
        <button type="submit" class="button is-block is-info is-fullwidth">
          Register
        </button>
      </form>
      <hr>
      <a class="button" href="{{ route('social.login', 'google') }}">Login with Google</a>
      <a class="button" href="{{ route('social.login', 'twitter') }}">Login with Twitter</a>
    </div>
    <p class="has-text-grey">
      <a href="{{ route('login') }}">Login</a>
    </p>
  </div>
</div>
@endsection
