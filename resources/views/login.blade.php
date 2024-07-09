@extends('layouts.auth')
@section('content')
<div class="forms">
    <div class="form-content">
      <div class="login-form">
        <div class="title">Login</div>
      <form action="#"  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-boxes">
          <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="Enter your email" required name="email" id="email">
          </div>
          <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Enter your password" required name="password" id="password">
          </div>
          <div class="text"><a href="#">Forgot password?</a></div>
          <div class="button input-box">
            <input type="submit" value="Sumbit" id="login_btn">
          </div>
          <div class="text sign-up-text" style="display: none;"><label for="flip" id="fliping_element">Sigup now</label></div>
        </div>
    </form>
  </div>
    <div class="signup-form">
      <div class="title">Signup</div>
    <form action="#" method="POST">
        @csrf
        <div class="input-boxes">
          <div class="input-box">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Enter your name" required>
          </div>
          <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="Enter your email" required>
          </div>
          <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Enter your password" required>
          </div>
          <div class="button input-box">
            <input type="submit" value="Sumbit">
          </div>
          <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
        </div>
  </form>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
    $('#login_btn').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route('auth') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token
                email: $('#email').val(),
                password: $('#password').val()
            },
            success: function(response) {
                $('#fliping_element').click();
                @this.notify('This is a test notification', 'success');
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});
</script>
@endsection
