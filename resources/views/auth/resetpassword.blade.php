@extends('layouts.auth')
@section('content')
<div class="forms">
    <div class="form-content">
      <div class="login-form">
        <img src="{{ asset('Images/logo.png') }}" alt="logo" width="150px" height="150px" style="margin: 0px 0px -30px -10px;">
        <div class="title">Reset Password</div>
        <small>Please fill this form to reset your password. </small>
        <div style="background-color:whitesmoke;padding:20px;">
            <small id="passwordHelp" class="form-text text-muted">
                <em>
                    <span style= "color:red;" id="rule1">-	At least be 8 characters long.</span><br>
                    <span style= "color:red;" id="rule2">-	At least have one lower case letter.</span><br>
                    <span style= "color:red;" id="rule3">-	At least have one upper case letter.</span><br>
                    <span style= "color:red;" id="rule4">- At least have one number.</span><br>
                    <span style= "color:red;" id="rule5">- At least have one special character.</span><br>
                </em>
            </small>
        </div>
      <form id="forgot-password-form" action="{{ route('reset-Password') }}"  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-boxes">
          <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Enter your email" required name="email" id="email" value="{{$email}}">
          </div>
          <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Enter your new password" required name="password" id="password">
          </div>
          <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" required name="password_confirmation" id="password_confirmation">
          </div>
          <input type="hidden" name = "token" value="{{$token}}">
          <div class="button input-box">
            <input type="submit" value="Sumbit" id="submit_btn">
          </div>
        </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#forgot-password-form').on('submit', function(event) {
            event.preventDefault();

            $("#submit_btn").val('loading...');

            if($("#password_confirmation").val() != $("#password").val()){
                $("#submit_btn").val('Submit');
                toastr.error('Passwords don\'t match', 'Password Error');
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        $("#submit_btn").val('Submit');
                        toastr.success(response.message, 'Password has been updated successfully');
                        
                        // redirect to loggin after 5 seconds
                        window.setTimeout(function() {
                            window.location.href = response.route;
                        }, 5000);

                    } else {
                        $("#submit_btn").val('Submit');
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    $("#submit_btn").val('Submit');
                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
