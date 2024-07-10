@extends('layouts.auth')
@section('content')
<div class="forms">
    <div class="form-content">
      <div class="login-form">
        <img src="{{ asset('Images/logo.png') }}" alt="logo" width="150px" height="150px" style="margin: 0px 0px -30px -10px;">
        <div class="title">Forgot Password</div>
        <small>Please fill this form to request for reset password link via email.</small>
      <form id="forgot-password-form" action="{{ route('send-password-reset-link') }}"  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-boxes">
          <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Enter your email" required name="email" id="email">
          </div>
          <div class="button input-box">
            <input type="submit" value="Sumbit" id="submit_btn">
          </div>
          <div class="text sign-up-text">back to <a href="{{route('login')}}">login?</a></div>
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

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        $("#submit_btn").val('Submit');
                        toastr.success(response.message, 'Rest Password email has been successfully');
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
