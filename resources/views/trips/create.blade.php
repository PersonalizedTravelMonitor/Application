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
          <span>Trenord</span>
        </a>
      </li>
      <li class="select-tab" data-tab="subway">
        <a>
          <span class="icon is-small"><i class="fa fa-subway"></i></span>
          <span>Subway</span>
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

  <hr>
  <div id="repetition-days-section" style="display:none">
    <h2 class="title is-4" align="center">Choose wich days to repeat</h2>
    <div class="buttons has-addons is-centered">
        <span class="button is-selected is-info" id="button-today" >Just Today
      </span>
        <span class="button" id="button-multiple" v >Multiple Days
      </span>
    </div>
    <br>

    <div id="days-list" class="columns is-centered" style="display:none" >
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Monday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Tuesday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Wednesday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Thursday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded is-selected is-info">Friday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded">Saturday</a>
      </div>
      <div class="column is-narrow">
        <a class="button is-rounded">Sunday</a>
      </div>
    </div>
    <br>
    <div class="columns is-centered">
      <div class="column is-narrow">
        <button class="button is-success is-medium" id="btn-subscribe">
          <span class="icon is-small">
            <i class="fas fa-check"></i>
          </span>
          <span>Follow this trip</span>
        </button>
      </div>
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
    $("#button-multiple").click(function(){
        $("#button-today").removeClass("is-selected").removeClass("is-info");
        $(this).toggleClass("is-selected").toggleClass("is-info");
        $("#days-list").show();
    })
  });
</script>

<script>
  $(document).ready(function() {
    $("#button-today").click(function(){
        $("#button-multiple").removeClass("is-selected").removeClass("is-info");
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


