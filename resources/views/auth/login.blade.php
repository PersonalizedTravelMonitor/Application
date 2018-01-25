@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h3 class="title has-text-grey">Login</h3>
          <p class="subtitle has-text-grey">Please login to proceed.</p>
          <div class="box">
            <figure class="avatar">
              <img src="https://placehold.it/128x128">
            </figure>
            <form method="POST" action={{ route('login') }}>
              {{csrf_field() }}
              <div class="field">
                <div class="control">
                  <input class="input is-large" name="email" value="{{old('email') }}" id="email" type="email" placeholder="Your Email" autofocus="" required>
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <input class="input is-large" name="password" id="password" type="password" placeholder="Your Password" required>
                </div>
              </div>
              <div class="field">
                <label class="checkbox">
                  <input type="checkbox" name="remembrer" {{ old('remember') ? 'checked' : ''}} >
                  Remember me
                </label>
              </div>
              <button type="submit" class="button is-block is-info is-large">
                Login
              </button>
            </form>
          </div>
          <p class="has-text-grey">
            <a href="{{ route('register') }}">Sign Up</a> &nbsp;·&nbsp;
            <a href="{{ route('password.request') }}/">Forgot Password</a> &nbsp;·&nbsp;
          </p>
        </div>
      </div>
@endsection
