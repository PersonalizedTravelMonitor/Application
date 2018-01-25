<div class="columns">
    <div class="column">
      <div class="field">
        <label class="label">From: </label>
        <div class="control has-icons-left">
          <input class="input autocompleteFrom" type="text" placeholder="Departure Station Name">
          <span class="icon is-small is-left">
          <i class="fas fa-map-marker"></i> </span>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="field">
        <label class="label">To: </label>
        <div class="control has-icons-left">
          <input class="input autocompleteTo" type="text" placeholder="Arrival Station Name">
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
