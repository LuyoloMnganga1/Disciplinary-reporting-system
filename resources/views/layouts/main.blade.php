<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disciplinary Report System</title>
    <link rel="icon" href="{{asset('Images/logo.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
  </head>
  <style>
    .navbar-custom {
        background-color: black;
        color: white;
        border-top:5px solid gray;
        border-bottom:5px solid gray;
    }
    .navbar-custom .navbar-nav .nav-link {
       padding: 0px 20px 0px 20px;
    }
    .navbar-custom .navbar-nav .nav-link.active {
        background-color: white;
        color: black;
        border-radius: 10px;
    }
    .dropdown-menu {
            z-index: 1051; /* Higher than the default navbar z-index */
        }
</style>
  <body>
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light p-1">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand pl-3" href="#">
                <img src="{{asset('Images/logo.png')}}" alt="" width="80px" height="80px">
            </a>
            <!-- System Menu -->
            <div class="navbar-nav mx-auto">
                <a class="nav-link text-dark text-uppercase" href="{{route('dashboard')}}">Disciplinary Report System</a>
            </div>
            <!-- User Dropdown -->
            <div class="dropdown pr-3">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->name}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Horizontal Navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-custom" >
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : ''}}" href="#"><i class="fa fa-home {{ request()->is('dashboard') ? 'text-dark' : 'text-light'}}"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Disciplinaries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Utilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Audit Trails</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-5">
        @yield('content')
    </div>
  </body>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('scripts')
</html>
