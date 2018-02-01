<form onsubmit="return submitForm()">
  <div class="columns">
    <div class="column">
      <div class="field">
        <label class="label">From: </label>
        <div class="control has-icons-left">
          <input id="input-from" class="input autocompleteFrom" type="text" placeholder="Departure Station" autocomplete="off" required>
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">To: </label>
        <div class="control has-icons-left">
          <input id="input-to" class="input autocompleteTo" type="text" placeholder="Arrival Station" autocomplete="off" required>
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
              <input id="input-hours" class="input" type="number" min="0" max="23" value="{{ Carbon\Carbon::now('Europe/Rome')->format('H') }}" placeholder="Departure Hours" required>
              <span class="icon is-small is-left">
              <i class="fas fa-clock"></i> </span>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="field">
            <label class="label">Minutes: </label>
            <div class="control has-icons-left">
              <input id="input-minutes" class="input" type="number" min="0" max="60" value="00" placeholder="Departure Minutes" required>
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
  <div class="column">
    <br>
    <div class="notification is-light has-text-centered">
      Use the form above to search for a trip
    </div>
  </div>
</div>
<script type="text/template" name="search-result">
    <div class="column is-half">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon is-small" ><i class="fas fa-clock"></i></span>&nbsp;
            <span>[[ trip.departure_time ]]</span> <span class="icon is-small" ><i class="fas fa-caret-right"></i></span>&nbsp; <span>[[ trip.arrival_time ]]</span>
          </p>
          <div class="card-header-icon">
            <button class="button id-[[ index ]] selectButton" data-index="[[ index ]]">
              <span>Select</span>
            </button>
          </div>
        </header>
        <div class="card-content">
          <div class="content">
            <ul>
              [[ #trip.journey_list ]]
                <li>[[ train.train_category ]] [[ train.train_name ]] to <b>[[ train.direction ]]</b> ([[ stops.length ]] stops)
                <br>
                <p class="is-size-7">Get off at [[ last_stop.station.station_name ]] ([[ last_stop.arrival_time ]])</p> </li>
                [[ /trip.journey_list ]]
            </ul>
            <b>Duration : </b>[[ trip.duration ]]
            [[ #trip.skipped_some ]]
            <br>
            <br>
            <div class="notification is-light">
              Some parts of the trips were not included since are currently not supported. For example busses, metros or walking to the destination.
            </div>
            [[ /trip.skipped_some]]
          </div>
        </div>
      </div>
      <br>
    </div>
</script>


<script type="text/javascript">
  var selectedSolutions=null;

  $(document).ready(function() {
    $(".autocompleteFrom").autocomplete({
      source: "{{ route('search.autocompleteFrom', 'trenord') }}",
      minLength: 2,
      delay: 100,
    });
    $(".autocompleteTo").autocomplete({
      source: "{{ route('search.autocompleteTo', 'trenord') }}",
      minLength: 2,
      delay: 100,
    });
  });

  $(document).ready(function() {
    $("#btn-subscribe").click(function(){
      $("#btn-subscribe").addClass("is-loading");

      if(selectedSolutions){
        var repetitionDays = detectRepetitionDays();
        var  subscribeResult = $.post("{{route('trips.store')}}",{"trip": selectedSolutions  , "repetition": repetitionDays});

        subscribeResult.done(function (data, textStatus, jqXHR){
          $("#btn-subscribe").removeClass("is-loading");
          sessionStorage.setItem("inserted",true);
          sessionStorage.setItem("message","The trip was correctly submitted");
          $(window.location).attr('href', "{{route('home')}}");
        })
        subscribeResult.fail(function( jqXHR, textStatus, errorThrown ) {
          $("#btn-subscribe").removeClass("is-loading");
          alert("Something bad happened sendind the request");
        });
      }
    });
  });

  function detectRepetitionDays()
  {
    var repetitionDays=[];
    var i=0;
    if($("#radio-multiple").hasClass("is-selected")){
      var days_list=$("#days-list");
      $(days_list).children().each(function(){
        if($(this).find("a").hasClass("is-selected")){
          repetitionDays.push(i);
        }
        i++;
      });

    }
    return repetitionDays;
  }
  function submitForm() {
    $("#btn-search").addClass("is-loading");
    var from = $("#input-from").val();
    var to = $("#input-to").val();
    var hours = $("#input-hours").val();
    var minutes = $("#input-minutes").val();

    $.get('{{ route('search.searchSolutions', 'trenord') }}', { "from": from, "to": to, "hours": hours, "minutes": minutes }, function(data){

      displaySearchResults(data);

    });
    return false;
  }

  function displaySearchResults(results){
    results = results.slice(0, 4);
    $(".results").empty();
    if(results.length==0){
      $(".results").text("No compatible solutions found; the only provider supported, at the moment, is Trenord");
      return;
    }


    for(var i=0; i<results.length;i++){
      var trip=results[i];
      var templateViewHtml = $('script[name="search-result"]').html();
      Mustache.parse(templateViewHtml, ["[[", "]]"]);
      for (var j=0; j < trip.journey_list.length; j++) {
        stops = trip.journey_list[j].stops;
        trip.journey_list[j].last_stop = stops[stops.length-1];
      }
      console.log(trip)
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
        $(".selectButton").text("Select");
        $(this).addClass("is-info");
        $(this).text("Selected");
        selectedSolutions=results[$(this).data("index")];
        // Mostra sezione ripetizione
        $("#repetition-days-section").show();
        $('html, body').animate({
          scrollTop: $("#repetition-days-section").offset().top
        }, 500);
        $("#btn-search").removeClass("is-loading");

      });

    }


  }
</script>
