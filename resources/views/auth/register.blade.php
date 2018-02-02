@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
<div class="container has-text-centered">
  <div class="column is-4 is-offset-4">
    <h3 class="title has-text-grey">Register</h3>
    <p class="subtitle has-text-grey">Please register to proceed.</p>
    <div class="box">
      <figure class="avatar">
      <img src="{{ asset('img/logoPTM.png') }}">
      </figure>
      <form method="POST" action={{ route('register') }}>
        {{csrf_field() }}
        <div class="field">
          <p class="control has-icons-left">
            <input
              @if ($errors->has('name'))
                class="input is-danger"
              @else
                class="input"
              @endif
              name="name" value="{{old('name') }}" id="name" type="text" placeholder="Your Name" autofocus="" required>
            <span class="icon is-small is-left">
              <i class="fas fa-pencil-alt"></i>
            </span>
            @if ($errors->has('name'))
              <span class="help is-danger">
                {{ $errors->first('name') }}
              </span>
            @endif
          </p>
        </div>
        <div class="field">
          <p class="control has-icons-left">
            <input
              @if ($errors->has('email'))
                class="input is-danger"
              @else
                class="input"
              @endif
              name="email" value="{{old('email') }}" id="email" type="email" placeholder="Your Email" required>
            <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
            @if ($errors->has('email'))
              <span class="help is-danger">
                {{ $errors->first('email') }}
              </span>
            @endif
          </p>
        </div>
        <div class="field">
          <p class="control has-icons-left">
            <input
              @if ($errors->has('password'))
                class="input is-danger"
              @else
                class="input"
              @endif
              name="password" id="password" type="password" placeholder="Your Password" required>
            <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
            @if ($errors->has('password'))
              <span class="help is-danger">
                {{ $errors->first('password') }}
              </span>
            @endif
          </p>
        </div>
        <div class="field">
          <p class="control has-icons-left">
            <input
              @if ($errors->has('password_confirmation'))
                class="input is-danger"
              @else
                class="input"
              @endif
              name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Your Password" required>
            <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
            @if ($errors->has('password_confirmation'))
              <span class="help is-danger">
                {{ $errors->first('password_confirmation') }}
              </span>
            @endif
          </p>
        </div>
        <button type="submit" class="button is-info is-fullwidth">
          <span>Register</span>
          <span class="icon">
            <i class="fas fa-user-plus"></i>
          </span>
        </button>
      </form>
      <hr>
      <a class="button is-rounded" style="background-color:#db4437; color:white" href="{{ route('social.login', 'google') }}">
        <span class="icon">
          <i class="fab fa-google"></i>
        </span>
        <span>Login with Google</span>
      </a>
      <a class="button is-rounded" style="background-color:#5baaf4; color:white" href="{{ route('social.login', 'twitter') }}">
        <span class="icon">
          <i class="fab fa-twitter"></i>
        </span>
        <span>Login with Twitter</span>
      </a>
    </div>
    <p class="has-text-grey">
      <a href="{{ route('login') }}">Login</a>
    </p>
  </div>
</div>
@endsection
