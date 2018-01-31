@extends('layouts.app')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
@endsection

@section('content')
  <h1 class="title" align="center">Get updates on a trip</h1>
  <div class="notification is-light">
    Here you can search for a trip you wish to follow.<br>
    Search, select your vehicle, select the days of the week and you're done!
    <br><br>
    You will receive notifications for your trip.
</div>

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
    <p id="fromStation"></p>
    <p id="toStation"></p>
    @include('trips.createTrain')
  </div>
  <div class="tab tab--subway" style="display:none">
    @include('trips.createSubway')
  </div>
  <div class="tab tab--bus" style="display:none">
    @include('trips.createBus')
  </div>
  <div class="tab tab--tram" style="display:none">
    @include('trips.createTram')
  </div>

  <div id="repetition-days-section" style="display:none">
    <h2 class="title is-5" align="center">Repeting on</h2>
    <div class="buttons has-addons is-centered">
        <span class="button is-selected is-info" id="radio-today" >Just Today
      </span>
        <span class="button" id="radio-multiple" v >Multiple Days
      </span>
    </div>
    <br>

    <div id="days-list" class="columns is-centered" style="display:none" >
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Lunedì</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Martedì</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Mercoledì</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Giovedì</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Venerdì</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded">Sabato</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded">Domenica</a>
      </div>
    </div>
    <br>
    <div class="buttons is-right">
      <button class="button is-success" id="btn-subscribe">Programma Viaggio</button>
    </div>

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
  });

</script>

<script>
  $(document).ready(function() {
    $("#radio-multiple").click(function(){
        $("#radio-today").removeClass("is-selected").removeClass("is-info");
        $(this).toggleClass("is-selected").toggleClass("is-info");
        $("#days-list").show();
    })
  });
</script>

<script>
  $(document).ready(function() {
    $("#radio-today").click(function(){
        $("#radio-multiple").removeClass("is-selected").removeClass("is-info");
        $(this).toggleClass("is-selected").toggleClass("is-info");
        $("#days-list").hide();
    })
  });
</script>

<script>
  $(document).ready(function() {
    $("#days-list div a").click(function() {
      $(this).toggleClass("is-selected").toggleClass("is-info");
    })
  });
</script>
@endsection


