<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <tItle>Disciplinary Report System</tItle>
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="{{ asset('images/frontImg.jpg')}}" alt="">
        <div class="text">
          <span class="text-1">HRF Outsourcing & Labour Law Services <br></span>
          <span class="text-2">has a great team of professionals currently managing over 4500 employee payroll profiles across 120 client sites.</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="{{asset('images/backImg.jpg')}}" alt="">
        <div class="text">
            <span class="text-1">HRF Outsourcing & Labour Law Services <br></span>
            <span class="text-2">has a great team of professionals currently managing over 4500 employee payroll profiles across 120 client sites.</span>
        </div>
      </div>
    </div>
        @yield('content')
    </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</html>
