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
  <div class="card search-result">
    <header class="card-header">
      <p class="card-header-title">
        <span class="search-result-from"></span>
        <span class="search-result-to"></span>
        <span class="search-result-departure-time"></span>
      </p>
      
    </header>
    <div class="card-content">
      <div class="content">
        Bla bla bla
      </div>
    </div>

  </div>
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#btn-search").click(function() {
      var from = $("#input-from").val();
      var to = $("#input-to").val();
      var hours = $("#input-hours").val();
      var minutes = $("#input-minutes").val();

      $.get('{{ route('search.searchSolutions', 'trenord') }}', { "from": from, "to": to, "hours": hours, "minutes": minutes }, function(data){
          displaySearchResults(data);
        });
    });
  });

  function displaySearchResults(results){
    for(result of results){
      var searchResult = $("script[name=search-result]").html();
      $(searchResult).find(".search-result-departure-time").text("666");
      console.log(result);
      $(".results").append(searchResult);
    }
  }
</script>