<div class="columns">
  <div class="column">
    <div class="field">
      <label class="label">From: </label>
      <div class="control has-icons-left">
        <input id="input-from" class="input autocompleteFrom" type="text" placeholder="Departure Station Name">
        <span class="icon is-small is-left">
        <i class="fas fa-map-marker"></i> </span>
      </div>
    </div>
  </div>
  <div class="column">
    <div class="field">
      <label class="label">To: </label>
      <div class="control has-icons-left">
        <input id="input-to" class="input autocompleteTo" type="text" placeholder="Arrival Station Name">
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
    <button id="btn-search" class="button is-fullwidth is-info">
      <span>Search</span>
      <span class="icon">
        <i class="fas fa-search"></i>
      </span>
    </button>
  </div>
</div>

<div class="results">
</div>

<script type="text/template" name="search-result">
  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        [[ trip.departure_station.station_name ]] ([[ trip.departure_time ]])
        [[ trip.arrival_station.station_name ]] ([[ trip.arrival_time ]])
      </p>
    </header>
    <div class="card-content">
      <div class="content">
        <ul>
          [[ #trip.journey_list ]]
            <li>[[ train.train_category ]] [[ train.train_name ]] ([[ stops.length ]] stops)</li>
          [[ /trip.journey_list ]]
        </ul>
      </div>
    </div>
  </div>
  <br>
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#btn-search").click(function() {
      $(this).addClass("is-loading");
      var from = $("#input-from").val();
      var to = $("#input-to").val();
      var hours = $("#input-hours").val();
      var minutes = $("#input-minutes").val();

      $.get('{{ route('search.searchSolutions', 'trenord') }}', { "from": from, "to": to, "hours": hours, "minutes": minutes }, function(data){
        $("#btn-search").removeClass("is-loading");
        displaySearchResults(data);
      });
    });
  });

  function displaySearchResults(results){
    results = results.slice(0, 3);
    $(".results").empty();
    for(trip of results){
      console.log(trip);
      var templateViewHtml = $('script[name="search-result"]').html();
      Mustache.parse(templateViewHtml, ["[[", "]]"]);
      var renderedSearch = Mustache.render(templateViewHtml, {"trip": trip });
      $(".results").append(renderedSearch);
    }
  }
</script>
