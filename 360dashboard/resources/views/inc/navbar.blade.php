<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="home">Company Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="about">About <span class="sr-only">(current)</span></a>
            </li>
            @auth
            <li class="nav-item">
              <a class="nav-link" href="overview">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sales">Sales</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="suppliers">Suppliers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inventory">Inventory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="financial">Financial</a>
            </li>
            @endauth
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            @guest
              <li><a style="color: white" href="{{ route('login') }}">Login</a></li>
              <li><a style="color: white" href="{{ route('register') }}">&ensp;Register</a></li>
            @endguest
            @auth
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="saft"> Saft Menu</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endauth
        </ul>
        </div>
      </nav>
