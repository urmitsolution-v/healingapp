<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - Admin Dashboard</title>

    <!-- Meta -->
    <meta name="description" content="Admin Dashboard">
    <meta property="og:title" content="{{ env('APP_NAME') }} - Admin Dashboard">
    <meta property="og:description" content="Admin Dashboard">
    <meta property="og:type" content="Website">
    <link rel="shortcut icon" href="{{ url('newadmin') }}/assets/images/favicon.svg">

    <!-- *************
		************ CSS Files *************
	************* -->
    <link rel="stylesheet" href="{{ url('newadmin') }}/assets/fonts/remix/remixicon.css">
    <link rel="stylesheet" href="{{ url('newadmin') }}/assets/css/main.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


    <!-- *************
		************ Vendor Css Files *************
	************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{ url('newadmin') }}/assets/vendor/overlay-scroll/OverlayScrollbars.min.css">

    @yield('css')

  </head>

  <body>

    <style>
      .treeview-menu li.active a{
        color: #116aef;
      }
    </style>


    <!-- Page wrapper starts -->
    <div class="page-wrapper">

      <!-- App header starts -->
      <div class="app-header d-flex align-items-center">

        <!-- Toggle buttons starts -->
        <div class="d-flex">
          <button class="toggle-sidebar">
            <i class="ri-menu-line"></i>
          </button>
          <button class="pin-sidebar">
            <i class="ri-menu-line"></i>
          </button>
        </div>
        <!-- Toggle buttons ends -->

        <!-- App brand starts -->
        <div class="app-brand ms-3">
          <a href="index.html" class="d-lg-block d-none">
            {{-- <img src="{{ url('newadmin') }}/assets/images/logo.svg" class="logo" alt="Medicare Admin Template"> --}}
          </a>
          <a href="index.html" class="d-lg-none d-md-block">
            {{-- <img src="{{ url('newadmin') }}/assets/images/logo-sm.svg" class="logo" alt="Medicare Admin Template"> --}}
          </a>
        </div>
        <!-- App brand ends -->

        <!-- App header actions starts -->
        <div class="header-actions">

          {{-- <!-- Search container starts -->
          <div class="search-container d-lg-block d-none mx-3">
            <input type="text" class="form-control" id="searchId" placeholder="Search">
            <i class="ri-search-line"></i>
          </div> --}}
          <!-- Search container ends -->

          <!-- Header actions starts -->
          
          <!-- Header actions ends -->

          <!-- Header user settings starts -->
          <div class="dropdown ms-2">
            <a id="userSettings" class="dropdown-toggle d-flex align-items-center" href="#!" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <div class="avatar-box">JB<span class="status busy"></span></div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg">
              <div class="px-3 py-2">
                <span class="small">Admin</span>
                <h6 class="m-0">{{ Auth::user()->name ?? "" }}</h6>
              </div>
              <div class="mx-3 my-2 d-grid">
                <a href="/logoutadmin" onclick="return confirm('Log Out ?')" class="btn btn-danger">Logout</a>
              </div>
            </div>
          </div>
          <!-- Header user settings ends -->

        </div>
        <!-- App header actions ends -->

      </div>
      <!-- App header ends -->

      <!-- Main container starts -->
      <div class="main-container">
    @include('layout.sidebar')


        @yield('content')


        
      </div>
      <!-- Main container ends -->

    </div>
    <!-- Page wrapper ends -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ url('newadmin') }}/assets/js/jquery.min.js"></script>
    <script src="{{ url('newadmin') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('newadmin') }}/assets/js/moment.min.js"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Overlay Scroll JS -->
    <script src="{{ url('newadmin') }}/assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

    <!-- Apex Charts -->
    <script src="{{ url('newadmin') }}/assets/vendor/apex/apexcharts.min.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/patients.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/treatment.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/available-beds.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/earnings.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/gender-age.js"></script>
    <script src="{{ url('newadmin') }}/assets/vendor/apex/custom/home/claims.js"></script>

    <!-- Custom JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ url('newadmin') }}/assets/js/custom.js"></script>
  
  
    @yield('scripts')

    <script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
</script>


  </body>

</html>
   