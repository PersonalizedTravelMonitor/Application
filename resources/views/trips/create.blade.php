@extends('layouts.app')

@section('content')
<form action="{{ route('trips.store') }}" method="POST">
  {{ csrf_field() }}

<h1 class="title" align="center">Create your Trip</h1>

  <div class="tabs is-centered is-boxed">
  <ul>
    <li class="is-active select-tab" data-tab="train">
      <a>
        <span class="icon is-small"><i class="fa fa-train"></i></span>
        <span>Train</span>
      </a>
    </li>
    <li class="select-tab" data-tab="subway">
      <a>
        <span class="icon is-small"><i class="fa fa-subway"></i></span>
        <span>Subway</span>
      </a>
    </li>
    <li class="select-tab" data-tab="bus">
      <a>
        <span class="icon is-small"><i class="fas fa-bus"></i></span>
        <span>Bus</span>
      </a>
    </li>
    <li class="select-tab" data-tab="tram">
      <a>
        <span class="icon is-small"><i class="fas fa-train"></i></span>
        <span>Tram</span>
      </a>
    </li>
  </ul>
</div>
<div class="tab tab--train">
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label">From: </label>
        <div class="control has-icons-left">
          <input class="input" type="text" placeholder="Departure Station Name">
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">To: </label>
        <div class="control has-icons-left">
          <input class="input" type="text" placeholder="Arrival Station Name">
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">Time: </label>
        <div class="control has-icons-left">
          <input class="input" type="text" placeholder="Departure Time">
          <span class="icon is-small is-left">
          <i class="fas fa-clock"></i> </span>
        </div>
      </div>
    </div>
  </div>

  <div class="columns">
    <div class="column">
      <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Treno 5040  -  From Lecco [12:00] To Rome [18:00]
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
          <span class="icon">
            <i class="fas fa-angle-down" aria-hidden="true"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
        <div class="columns">
        <div class="column">
          <b>Durata:</b> 5h 25m<br>
                <b>Compagnia:</b> Trenitalia<br>
                <b>Tipo di Viaggio:</b> Diretto<br>
                <br>
        </div>
        <div class="column">
          <img src="https://pbs.twimg.com/profile_images/1620236068/TRENORD_LOGO.jpg" width="80px" height="80px" align="right">
        </div>
        </div>
        </div>
      </div>
      <footer class="card-footer">
        <a href="#" class="card-footer-item">Più informazioni</a>
        <a href="#" class="card-footer-item">Seleziona</a>
      </footer>
    </div>
    </div>
    <div class="column">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Treno 5040  -  From Naples [18:00] To Reggio Calabria [22:00]
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
          <span class="icon">
            <i class="fas fa-angle-down" aria-hidden="true"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
        <div class="columns">
        <div class="column">
          <b>Durata:</b> 5h 25m<br>
          <b>Compagnia:</b> Trenord<br>
          <b>Tipo di Viaggio:</b> Diretto<br>
          <br>
        </div>
        <div class="column">
          <img src="https://cdn.logitravel.it/comun/images/trenes/companias/logos/logo_TIT.png" width="80px" height="80px" align="right">
        </div>
        </div>
        </div>
        </div>
      <footer class="card-footer">
        <a href="#" class="card-footer-item">Più informazioni</a>
        <a href="#" class="card-footer-item">Seleziona</a>
      </footer>
      </div>
      </div>
    </div>
  </div>
  </div>
  <br><hr>

  <div class="columns">
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Lunedì
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Martedì
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Mercoledì
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Giovedì
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Venerdì
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Sabato
</label>
  </div>
  <div class="column">
  <label class="checkbox">
  <input type="checkbox">
  Domenica
</label>
  </div>
</div>


</div>
<div class="tab tab--subway" style="display:none">
<h1>Sono il subway</h1></div>
<div class="tab tab--bus" style="display:none">
<h1>Sono il bus</h1></div>
<div class="tab tab--tram" style="display:none">
<h1>Sono il tram</h1>
</div>


@endsection


@section('scripts')
<script>
$(document).ready(function() {
  $(".select-tab").click(function() {
    var tabToShow = $(this).data("tab");
    $(".tab").hide();
    $(".tab--" + tabToShow).show();

    $(".select-tab").removeClass("is-active")
    $(this).addClass("is-active")
  })
})
</script>
@endsection


