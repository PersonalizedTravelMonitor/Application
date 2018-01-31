<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PTM') }}</title>

  <!-- Styles and Scripts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script>
    $(document).ready(function(){
      $.ajaxSetup({
        headers : { 'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content}
      })
    });
  </script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  @yield('head')
</head>
<body>
  <nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
        <img src="https://i.imgur.com/oYHwPyR.png" alt="Logo" ></img>
        </a>
        <button class="button navbar-burger" data-target="navMenu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <div class="navbar-menu" id="navMenu">
        <div class="navbar-end">
          @auth
            <a class="navbar-item is-active" a href="{{ route('home') }}">
              <span class="icon">
                <i class="fas fa-plane"></i>
              </span>
              Dashboard
            </a>
          @endauth
          @auth
            @if (Auth::user()->isAdmin)
              <a class="navbar-item" href="{{ route('admin.index') }}">
              <span class="icon">
                <i class="fas fa-chess-king"></i>
              </span>
              Admin
            </a>
            @endif
          @endauth
          @guest
            <a class="navbar-item" href="{{ route('login') }}">
              <span class="icon">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              Login
            </a>

            <a class="navbar-item" href="{{ route('register') }}">
              <span class="icon">
                <i class="fas fa-user-plus"></i>
              </span>
              Register
            </a>
          @endguest
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
            <span class="icon">
              <i class="fas fa-sign-out-alt"></i>
            </span>
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
  <section class="section" style="min-height:100vh">
    <div class="container">
      <div id="app">
        @yield('content')
      </div>
    </div>
  </section>
  <footer class="footer">
  <span class="container">
    <span class="content has-text-centered">
      <p>
      <h1 class="title is-4">
      <b>Personalized Travel Monitor</b>
    </h1>
    <h2 class="subtitle is-6">
      A project by <br><i>Cristian Baldi, Simone Galimberti, Fabrizio Olivadese, Simone Vitali</i>
      <br><br></h2>
      <h2 class="subtitle is-7">
      Developed for the Software Engineering course - UniMiB 2017/2018
    </h2>
      </p>
    </span>
  </span>
</footer>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Get all "navbar-burger" elements
      var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
      // Check if there are any navbar burgers
      if ($navbarBurgers.length > 0) {
        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
          $el.addEventListener('click', function () {
            // Get the target from the "data-target" attribute
            var target = $el.dataset.target;
            var $target = document.getElementById(target);

            // Toggle the class on both the "navbar-burger" and the "navbar-menu"
            $el.classList.toggle('is-active');
            $target.classList.toggle('is-active');

          });
        });
      }
    });
  </script>
  @yield('scripts')
</body>
</html>
