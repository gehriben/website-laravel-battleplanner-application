<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="/">Battle Planner</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarText">

    <ul class="navbar-nav mr-auto">
      
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/battleplan">Public Plans</a>
          </li>
      @auth
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="/room">Rooms</a>
        </li>
        
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{Auth::User()->username}}
          </a>
          <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href='#' onclick='logout()'>Logout</a>
          </div>
        </li>
      @endauth

      @guest
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="/login">Login</a>
        </li>

        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="/register">Register</a>
        </li>
      @endguest
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="https://tavernsidepodcast.com">
          <!-- <i class="fas fa-certificate new-tag"></i> -->
          <div class="new-tag">new</div>
          Podcast
        </a>
      </li>
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
