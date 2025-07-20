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
                         <div class="sign-in-logo"><a href="index.html"><img src="images/logo/logo.png" alt="" /></a></div>

                        <div class="sign-up-top mt-4">
                           <h2>Sohum Healing Bank</h2>
                           <p>Declaration</p>
                        </div>
                       <div class="sign-up-form">

   <p class="informationp">
      I promise that I have read all the information properly. I also agree to read the PDF properly which Managing team will provide me after submitting this form. I also confirm that I agree to the terms and conditions and will maintain confidentiality of Healers condition to whom I am assigned to heal. Also I confirm that the information being supplied is true and correct. And in any circumstances I’ll not share group link to anybody.
   </p>

  <div class="iaccept_box">
   <input type="checkbox" id="agree">
   <label for="agree">I Agree</label>
   
   
</div>
<span class="text-danger agree_error error-text d-block mt-1" style="display: none;"></span>
<div class="sign-botton">
   <button id="continueBtn" class="sign-up-btn">
      Continue
      <i class="fas fa-spinner fa-spin ms-2 d-none" id="continueLoader"></i>
   </button>
</div>


</div>
                     </div>
                  </div>
                
               </div>
            </div>
         </div>
      </div>

      <script src="{{ url('') }}/js/jquery.min.js"></script>

     <script>
        $(document).ready(function () {
   $('#continueBtn').on('click', function (e) {
      e.preventDefault();

      // Clear previous errors
      $('.agree_error').text('').hide();

      // Check if checkbox is checked
      if (!$('#agree').is(':checked')) {
         $('.agree_error').text('Please accept the agreement before continuing.').show();
         return;
      }

      // Show spinner and disable button temporarily
      $(this).prop('disabled', true);
      $('#continueLoader').removeClass('d-none');

      $.ajax({
         url: "{{ route('user.final.submit') }}",
         method: "POST",
         data: {
            _token: "{{ csrf_token() }}",
            agreed: true
         },
         success: function (response) {
            // Redirect to homepage
            window.location.href = "{{ url('/') }}";
         },
         error: function () {
            $('#continueBtn').prop('disabled', false);
            $('#continueLoader').addClass('d-none');
         }
      });
   });
});

     </script>

    </body>
</html>
