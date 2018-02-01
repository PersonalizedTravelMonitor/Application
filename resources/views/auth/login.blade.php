@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
<div class="container has-text-centered">
  <div class="column is-4 is-offset-4">
    <h3 class="title has-text-grey">Login</h3>
    <p class="subtitle has-text-grey">Please login to proceed.</p>
    <div class="box">
      <figure class="avatar">
        <img src="https://i.imgur.com/oWaOvLu.png">
      </figure>
      <form method="POST" action={{ route('login') }}>
        {{csrf_field() }}
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
          <label class="checkbox">
            <input type="checkbox" name="remembrer" {{ old('remember') ? 'checked' : ''}} >
            Remember me
          </label>
        </div>
        <button type="submit" class="button is-block is-info is-fullwidth">
          Login
        </button>
      </form>
      <hr>
      <a class="button" style="background-color:#db4437; color:white" href="{{ route('social.login', 'google') }}">
        <span class="icon">
          <i class="fab fa-google"></i>
        </span>
        <span>Login with Google</span>
      </a>
      <a class="button" style="background-color:#5baaf4; color:white" href="{{ route('social.login', 'twitter') }}">
        <span class="icon">
          <i class="fab fa-twitter"></i>
        </span>
        <span>Login with Twitter</span>
      </a>
    </div>
    <p class="has-text-grey">
      <a href="{{ route('register') }}">Sign Up</a> &nbsp;·&nbsp;
      <a href="{{ route('password.request') }}/">Forgot Password</a> &nbsp;·&nbsp;
    </p>
  </div>
</div>
@endsection
