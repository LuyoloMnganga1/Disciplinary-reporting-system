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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.bootstrap5.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  </head>
  <body>
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light p-1">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand pl-3" href="{{route('dashboard')}}">
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
    <nav class="navbar sticky-top navbar-expand-lg navbar-custom align-items-center justify-content-between" >
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : ''}} {{ request()->is('dashboard') ? 'text-dark' : 'text-light'}}" href="{{route('dashboard')}}"><i class="fa fa-home {{ request()->is('dashboard') ? 'text-dark' : 'text-light'}}"></i> Dashboard</a>
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
                    @if (Auth::user()->role == 'Super Admin')
                    <li class="nav-item">
                        <a class="nav-link text-light {{ request()->is('users') ? 'active' : ''}}" href="{{route('users')}}">User Management</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Utilities</a>
                    </li>
                    @if (Auth::user()->role == 'Super Admin')
                    <li class="nav-item">
                        <a class="nav-link text-light {{ request()->is('audit') ? 'active' : ''}}" href="{{route('audit')}}">Audit Trails</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-5">
        @yield('content')
    </div>
  </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.bootstrap5.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':

                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':

                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':

                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':

                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
</script>
    @yield('scripts')
    <div class="footer py-0 mt-3" style="width:100%;">
        <div class="footer-copyright text-center p-1 bg-dark text-white"
            style="border-top:3px solid gray; border-bottom:3px solid gray; font-size:0.75rem;"> &copy; {{ now()->year }}
            <span class="text-white">Disciplinary Report System. Designed by <a href="https://ictchoice.com/" target="_blank" style="text-decoration: none;color: gold">SMS ICT Choice Pty (Ltd)</a></span>
        </div>
    </div>
</html>
