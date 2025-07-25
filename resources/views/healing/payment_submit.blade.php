<!DOCTYPE html>
<html><head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Healing Bank - Submit Payment</title>

      @include('healing.layout.css')
      
    </head>
   <body class="body-container">
      <style type="text/css">
         .sign-in-logo{
               text-align: center;
               padding: 30px 0;
               padding-top: 0px;
         }
         .qrcodeImageBox img{
            width:100%;
         }
         .sign-form-fild label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #000;
    padding-bottom: 3px;
    text-align: left;
}
      </style>
      <div class="main-container">
         <div id="app">
            <div class="page">
               <div class="page-content">
                  <div class="sign-in-page segments">
                    
                     <div class="sign-up-section">
                         <div class="sign-in-logo">
                           <div class="sign-up-top mt-4">
                           <h2>Sohum Healing Bank</h2>
                           <p>Make Payment</p>
                        </div>

                        @if (session('error'))
    <div class="custom-alert error-alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif

       <form id="paymentForm">
    @csrf
    <div class="sign-up-form">
        <div class=" qrcode_image">
            
            <div class="qrcodeImageBox">
                <img src="{{ url('images/qrcode.png') }}" alt="">
            </div>
        </div>

         <div class="sign-form-fild">
            <label for="screenshop">Upload Payment Screenshot</label>
            <input type="file" name="screenshop" id="screenshop" accept="image/*">
            <span class="error-text screenshop_error text-danger"></span>
        </div>

        <div class="sign-form-fild">
            <label for="certificate">Upload Certificate</label>
            <input type="file" name="certificate" id="certificate" accept="image/*">
            <span class="error-text certificate_error text-danger"></span>
        </div>

        <div class="sign-form-fild fild-icon1">
            <input type="number" name="utr_no" placeholder="UTR No & transaction ID" id="utr_no">
            <span class="error-text phone_error text-danger"></span>
        </div>

        <div class="sign-botton">
            <button type="submit" class="sign-up-btn" id="submitBtn">
                Continue <i id="btnSpinner" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
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
    $('#paymentForm').on('submit', function (e) {
        e.preventDefault();

        $('#submitBtn').prop('disabled', true);
        $('#btnSpinner').show();
        $('.error-text').text('');

        let formData = new FormData(this);
        formData.append('amount', 999); // Set default amount here

        $.ajax({
            url: "{{ url('/submit-payment') }}", // change as needed
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#btnSpinner').hide();

                if (response.status === 400) {
                    $.each(response.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else if (response.status === 200) {
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
</script>

</html>
