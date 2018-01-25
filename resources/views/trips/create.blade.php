@extends('layouts.app')

@section('content')
  <h1 class="title" align="center">Get updates on a trip</h1>
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

  <h2 class="title is-5" align="center">Select the days</h2>
  <div class="columns is-centered">
    <div class="column is-narrow">
      <a class="button is-rounded is-info is-selected">Lunedì</a>
    </div>
    <div class="column is-narrow">
      <a class="button is-rounded">Martedì</a>
    </div>
    <div class="column is-narrow">
      <a class="button is-rounded">Mercoledì</a>
    </div>
    <div class="column is-narrow">
      <a class="button is-rounded">Giovedì</a>
    </div>
    <div class="column is-narrow">
      <a class="button is-rounded">Venerdì</a>
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
    <span class="button is-success">Programma Viaggio</span>
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
    $(".button").click(function() {
      $(this).toggleClass("is-selected").toggleClass("is-info");
    })
  });
</script>

<script>
  $(document).ready(function() {
    $(".autocompleteFrom").autocomplete({
      source: "{{ route('search.autocompleteFrom', 'trenord') }}",
      minLength: 2,
      select: function(event, selected) {
        $("#fromStation").text(selected.item.id);
      }
    });
    $(".autocompleteTo").autocomplete({
      source: "{{ route('search.autocompleteTo', 'trenord') }}",
      minLength: 2,
      select: function(event, selected) {
        $("#toStation").text(selected.item.id);
      }
    });
  });
</script>
@endsection


