<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PTM') }}</title>

  <!-- Styles -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
</head>
<body>
  <nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          <img src="https://avatars3.githubusercontent.com/u/33867335" alt="PTM">
        </a>

        <button class="button navbar-burger">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <div class="navbar-menu">
        <div class="navbar-end">
          <a class="navbar-item" href="https://github.com/PersonalizedTravelMonitor/Application" target="_blank">
            <span class="icon">
              <i class="fab fa-github"></i>
            </span>
            Code
          </a>
          <a class="navbar-item" href="https://github.com/PersonalizedTravelMonitor/Documents" target="_blank">
            <span class="icon">
              <i class="fas fa-book"></i>
            </span>
            Documents
          </a>
          @auth
            <a class="navbar-item" href="#" onclick="document.querySelector('#logout-form').submit()">
              Logout
            </a>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
              {{ csrf_field() }}
            </form>
          @endauth
        </div>
      </div>
    </div>
  </nav>
  <section class="section">
    <div class="container">
      <h1 class="title">PTM</h1>
      <p class="subtitle">Your personal travel monitor!</p>
      <div id="app">
        @yield('content')
      </div>
    </div>
  </section>
</body>
</html>
