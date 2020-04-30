<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Battleplanner</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="/battleplan">Public Plans</a>
            </li>

            @auth
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="/room">Rooms</a>
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

            @admin
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="/admin">Admin</a>
            </li>
            @endif

        </ul>

        @auth
        <!-- <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search">
        </form> -->

        <ul class="navbar-nav form-inline my-2 my-md-0">
          <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{Auth::User()->username}}
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href='#' onclick='logout()'>Logout</a>
                </div>
          </li> -->
          
          

          <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/account">Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" onclick='logout()'>Logout</a>
          </li>

        </ul>
        @endauth
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
