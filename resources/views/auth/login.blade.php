@extends('layouts.auth')

@section('content')
<div class="forms">
    <div class="form-content">
        <div class="login-form">
            <img src="{{ asset('Images/logo.png') }}" alt="logo" width="150px" height="150px" style="margin: 0px 0px -30px -10px;">
            <h2>Disciplinary Report System</h2>
            <div class="title">Login</div>
            <form id="login-form" action="{{ route('authentication') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-boxes">
                    <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Enter your email" required name="email" id="email">
                    </div>
                    <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Enter your password" required name="password" id="password">
                    </div>
                    <div class="text"><a href="{{ route('forgot-password') }}">Forgot password?</a></div>
                    <div class="button input-box">
                        <input type="submit" value="Submit" id="login_btn">
                    </div>
                    <div class="text sign-up-text" style="display: none;"><label for="flip" id="fliping_element">Signup now</label></div>
                </div>
            </form>
        </div>
        <div class="signup-form">
            <img src="{{ asset('Images/logo.png') }}" alt="logo" width="150px" height="150px" style="margin: 0px 0px -30px -10px;">
            <div class="title">Verify One Time Pin</div>
            <form id="otp_form" action="{{ route('verify') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-boxes">
                    <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input type="text" placeholder="Enter your One Time Pin" required name="otp" id="otp">
                    </div>
                    <div class="button input-box">
                        <input type="submit" value="Submit" id="otp_btn">
                    </div>
                    <div class="text sign-up-text">Resend <label for="flip">One Time Pin?</label></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#login-form').on('submit', function(event) {
            event.preventDefault();

            $("#login_btn").val('loading...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        toastr.success(response.message, 'Logged in successfully');
                        $('#fliping_element').click();
                    } else {
                        $("#login_btn").val('Submit');
                        toastr.error(response.message, 'Login Error');
                    }
                },
                error: function(xhr) {
                    $("#login_btn").val('Submit');
                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        });

        $('#otp_form').on('submit', function(event) {
            event.preventDefault();

            $("#otp_btn").val('loading...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        toastr.success(response.message, 'OTP verified successfully');
                        window.location.href = response.route;
                    } else {
                        $("#otp_btn").val('Submit');
                        toastr.error(response.message, 'OTP Verification Error');
                    }
                },
                error: function(xhr) {
                    $("#otp_btn").val('Submit');
                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
