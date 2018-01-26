<form onsubmit="return submitForm()">
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label">From: </label>
        <div class="control has-icons-left">
          <input id="input-from" class="input autocompleteFrom" type="text" placeholder="Departure Station" autocomplete="off">
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">To: </label>
        <div class="control has-icons-left">
          <input id="input-to" class="input autocompleteTo" type="text" placeholder="Arrival Station">
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="columns">
        <div class="column">
          <div class="field">
            <label class="label">Hours: </label>
            <div class="control has-icons-left">
              <input id="input-hours" class="input" type="number" min="0" max="23" value="{{ Carbon\Carbon::now('Europe/Rome')->format('H') }}" placeholder="Departure Hours">
              <span class="icon is-small is-left">
              <i class="fas fa-clock"></i> </span>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="field">
            <label class="label">Minutes: </label>
            <div class="control has-icons-left">
              <input id="input-minutes" class="input" type="number" min="0" max="60" value="00" placeholder="Departure Minutes">
              <span class="icon is-small is-left">
              <i class="fas fa-clock"></i> </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="column" style="align-self: flex-end;">
      <button type="submit" id="btn-search" class="button is-fullwidth is-info">
        <span>Search</span>
        <span class="icon">
          <i class="fas fa-search"></i>
        </span>
      </button>
    </div>
  </div>
</form>

<div class="results columns is-multiline is-centered">
</div>

<script type="text/template" name="search-result">
    <div class="column is-half">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon is-small" ><i class="fas fa-clock"></i></span>&nbsp;
            <span>[[ trip.departure_time ]]</span>
          </p>
          <div class="card-header-icon">
            <button class="button id-[[ index ]] selectButton" data-index="[[ index ]]" >
              <span>Seleziona</span>
            </button>
          </div>
        </header>
        <div class="card-content">
          <div class="content">
            <ul>
              [[ #trip.journey_list ]]
                <li>[[ train.train_category ]] [[ train.train_name ]] to <b>[[ train.direction ]]</b> ([[ stops.length ]] stops)
                <br>
                <p class="is-size-7">Get off at [[ stops[stops.length-1].station.station_name ]]</p> </li>
                [[ /trip.journey_list ]]
            </ul>
          </div>
        </div>
      </div>
      <br>
    </div>
</script>


<script type="text/javascript">
  var selectedSolutions=null;

  $(document).ready(function() {
    $("#btn-subscribe").click(function(){
      if(selectedSolutions){
        $.post("{{route('trips.store')}}",{"trip": selectedSolutions});
      }
    });
  });

  function submitForm() {
    $(this).addClass("is-loading");
    var from = $("#input-from").val();
    var to = $("#input-to").val();
    var hours = $("#input-hours").val();
    var minutes = $("#input-minutes").val();

    $.get('{{ route('search.searchSolutions', 'trenord') }}', { "from": from, "to": to, "hours": hours, "minutes": minutes }, function(data){
      $("#btn-search").removeClass("is-loading");

      displaySearchResults(data);
    });
    return false;
  }

  function displaySearchResults(results){
    results = results.slice(0, 4);
    $(".results").empty();
    if(results.length==0){
      $(".results").text("No compatible solutions found");
      return;
    }
    for(var i=0; i<results.length;i++){
      var trip=results[i];
      console.log(trip);
      var templateViewHtml = $('script[name="search-result"]').html();
      Mustache.parse(templateViewHtml, ["[[", "]]"]);
      var renderedSearch = Mustache.render(templateViewHtml, {
        "trip": trip,
        "index": i,
        "cutTime": function() {
          return function(time, render) {
            return render(time).slice(0, -3);
          }
        }
      });
      $(".results").append(renderedSearch);

      $(".results .id-" + i).click(function(){
        $(".selectButton").removeClass("is-info");
        $(".selectButton").text("Seleziona");
        $(this).addClass("is-info");
        $(this).text("Selezionato");
        selectedSolutions=results[$(this).data("index")];
      });

    }

  }
</script>
