<!DOCTYPE html>
<html>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ env('APP_NAME') }}</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @include('healing.layout.css')
   </head>
   <body class="body-container">
    @yield('content')
      <div class="offcanvas">
         <button class="close-btn">Close</button>
         <div class="appointment-details boxv2">
                           <div class="details-top-section profile-main-page">
                              <div class="clinic-main">
                                 <div class="charges-details medicine-payment-details">
                                    
                                    <div class="profile-top-title">
                                       <h2>Lucy Martin</h2>
                                       <p>lucymartin@gmail.com</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="specialties-main profile-content-box">
                              <div class="special-main specialties-box">
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/appointments.png" alt=""></div>
                                       <span><a href="cardiologist.html">Cardiologist</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/pills.png" alt=""></div>
                                       <span><a href="cardiologist.html">Pills Reminder</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/doctor-icon1.png" alt=""></div>
                                       <span><a href="cardiologist.html">My Doctors</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/medicine-icn.png" alt=""></div>
                                       <span><a href="cardiologist.html">My Medicine</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/payment-icn.png" alt=""></div>
                                       <span><a href="cardiologist.html">Payment</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/my-address-icn1.png" alt=""></div>
                                       <span><a href="cardiologist.html">My Address</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/edit-account.png" alt=""></div>
                                       <span><a href="cardiologist.html">Edit Account</a></span>
                                    </div>
                                 </div>
                                 <div class="special-box">
                                    <div class="special-text-box">
                                       <div class="appointments"><img src="{{ url('healings') }}/images/settings-icn.png" alt=""></div>
                                       <span><a href="cardiologist.html">Settings</a></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>


      </div>


      <div class="offcanvas-backdrop"></div>

   <script src="{{ url('') }}/js/jquery.min.js"></script>
      
      {{-- <script src="{{ url('healings') }}/js/owl.carousel.min.html"></script> --}}
      <script src="{{ url('healings') }}/js/custom.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
      <script type="text/javascript">
    $(document).ready(function () {
      $(".open-btn").on("click", function () {
        $(".offcanvas").addClass("show");
        $(".offcanvas-backdrop").fadeIn(300);
      });

      $(".close-btn, .offcanvas-backdrop").on("click", function () {
        $(".offcanvas").removeClass("show");
        $(".offcanvas-backdrop").fadeOut(300);
      });
    });
      </script>      


@yield('scripts')

   </body>
</html>
