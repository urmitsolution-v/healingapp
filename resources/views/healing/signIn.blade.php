<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Healing Bank - Login</title>
        @include('healing.layout.css')
    </head>
   <body class="body-container">
      <div class="main-container">
         <div id="app">
            <div class="page">
               <div class="page-content">
                  <div class="sign-in-page segments">
                     <div class="navbar sign-header">
                        <div class="navbar-inner">
                        </div>
                     </div>
                     <div class="sign-up-section">
                        <div class="sign-in-logo"><a href="javascript:void(0)"><img src="{{ url('healings/images/logo/logo.png') }}" alt="" /></a></div>
                        <div class="sign-up-form">
    <form id="loginForm">
        @csrf

          @if (session('error'))
    <div class="custom-alert error-alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif


        <div id="errorMessage" class="custom-alert error-alert" style="display: none;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <span id="errorText"></span>
            <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>

        <div class="sign-form-fild fild-icon1">
            <input type="number" name="phone" id="phone" placeholder="Phone Number">
        </div>
        <div class="sign-form-fild fild-icon2">
            <input type="password" name="password" id="password" placeholder="Password">
        </div>

        <div class="forgot-text">
            <!-- <a href="forgot-password.html">Forgot Password?</a> -->
        </div>

        <div class="sign-botton">
            <button type="submit" class="sign-up-btn" id="loginBtn">
                <span id="loginText">Sign In</span>
                <i id="spinner" class="fas fa-spinner fa-spin" style="display: none; margin-left: 5px;"></i>
            </button>
        </div>

        <div class="sign-bottom-box">
            <span>Don’t have an Account?</span>
            <a class="signup-btn" href="/sign-up">Sign up</a>
        </div>
    </form>
</div>

                     </div>
                  </div>
                 
               </div>
            </div>
         </div>
      </div>



      <script src="{{ url('') }}/js/jquery.min.js"></script>

<script>
$('#loginForm').on('submit', function (e) {
    e.preventDefault();

    let phone = $('#phone').val().trim();
    let password = $('#password').val().trim();

    // Clear previous error
    $('#errorMessage').hide();
    $('#errorText').text('');

    // Client-side validation
    if (phone === '' || password === '') {
        $('#errorText').text('Phone number and password are required.');
        $('#errorMessage').show();
        return;
    }

    $('#loginBtn').prop('disabled', true);
    $('#spinner').show();
    $('#loginText').text('Signing In...');

    $.ajax({
        url: "{{ route('user.login.submit') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            phone: phone,
            password: password
        },
        success: function (response) {
            window.location.href = response.redirect;
        },
        error: function (xhr) {
            $('#loginBtn').prop('disabled', false);
            $('#spinner').hide();
            $('#loginText').text('Sign In');

            let message = 'Something went wrong.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            $('#errorText').text(message);
            $('#errorMessage').show();
        }
    });
});
</script>

    </body>
</html>
