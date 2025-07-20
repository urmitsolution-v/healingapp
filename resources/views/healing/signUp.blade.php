<!DOCTYPE html>
<html><head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Healing Bank - Sign Up</title>

      @include('healing.layout.css')
      
    </head>
   <body class="body-container">
      <style type="text/css">
         .sign-in-logo{
               text-align: center;
               padding: 30px 0;
               padding-top: 0px;
         }
      </style>
      <div class="main-container">
         <div id="app">
            <div class="page">
               <div class="page-content">
                  <div class="sign-in-page segments">
                    
                     <div class="sign-up-section">
                         <div class="sign-in-logo">
                            <a href="javascript:void(0);">
                            <img src="{{ url('healings') }}/images/logo/logo.png" alt="" /></a></div>

                        <div class="sign-up-top mt-4">
                           <h2>Sohum Healing Bank</h2>
                           <p>Enter Your details to create account</p>
                        </div>

                        @if (session('error'))
    <div class="custom-alert error-alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif

       <form id="registerForm">
    @csrf
    <div class="sign-up-form">
        <div class="sign-form-fild">
            <input type="text" name="name" placeholder="Full Name">
            <span class="error-text name_error text-danger"></span>
        </div>

        <div class="sign-form-fild fild-icon1">
            <input type="text" name="email" placeholder="Email Address">
            <span class="error-text email_error text-danger"></span>
        </div>

       <div class="sign-form-fild fild-icon2" style="position: relative;">
    <input type="password" name="password" id="password" placeholder="Password">
    <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999;"></i>
    <span class="error-text password_error text-danger"></span>
</div>

        <div class="sign-form-fild fild-icon1">
            <label>Date Of Birth</label>
            <input type="date" name="dob" placeholder="Date">
            <span class="error-text dob_error text-danger"></span>
        </div>

        <div class="sign-form-fild fild-icon1">
            <textarea class="form-control" name="address" placeholder="Address"></textarea>
            <span class="error-text address_error text-danger"></span>
        </div>

        <div class="sign-form-fild fild-icon1">
            <input type="number" name="phone" placeholder="Phone Number">
            <span class="error-text phone_error text-danger"></span>
        </div>

        <div class="sign-botton">
            <button type="submit" class="sign-up-btn" id="submitBtn">
                Sign Up <i id="btnSpinner" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
        </div>

        <div class="sign-bottom-box">
            <span>Already have Account?</span>
            <a class="signup-btn" href="/sign-in">Sign In</a>
        </div>
    </div>
</form>

                     </div>
                  </div>
                
               </div>
            </div>
         </div>
      </div>
   </body>

   <script src="{{ url('') }}/js/jquery.min.js"></script>

<script>
$(document).ready(function () {
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        $('#submitBtn').prop('disabled', true);
        $('#btnSpinner').show();
        $('.error-text').text('');

        $.ajax({
            url: "{{ url('/register-user') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#btnSpinner').hide();

                if (response.status == 400) {
                    $.each(response.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else if (response.status == 200) {
                    // alert(response.message);
                    window.location.href = "{{ url('/declearation') }}";
                }
            },
            error: function () {
                $('#submitBtn').prop('disabled', false);
                $('#btnSpinner').hide();
                alert('Something went wrong. Please try again.');
            }
        });
    });
});

  $(document).ready(function () {
        $('#togglePassword').on('click', function () {
            const passwordField = $('#password');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            
            // toggle the eye / eye-slash icon
            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });

</script>

</html>
