<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Rainbow Six Battleplanner</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/battleplan">Battleplans</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="https://www.patreon.com/battleplanner_app">
                  Patreon
                  <svg class="bi bi-heart-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                  </svg>
                </a>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto">
          @guest
          <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
          </li>

          <li class="nav-item">
              <a class="nav-link btn btn-primary btn-xl" style="max-width: 75px;" href="/register">Register</a>
          </li>
          @endguest

          @auth
            @admin
            <li class="nav-item">
                <a class="nav-link" href="/admin">Admin</a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="/account">Account</a>
            </li>

            <li class="nav-item">
              <a class="nav-link btn btn-primary" style="max-width: 75px;" onclick='logout()'>Logout</a>
            </li>
          @endauth
        </ul>

    </div>
</nav>


@push('js')
  <script type="text/javascript">
    function logout(){
      $.ajax({
        method: "POST",
        url: "/logout"
      })
      .done(function( msg ) {
        window.location.href = "/";
      });
    }
  </script>

@endpush
