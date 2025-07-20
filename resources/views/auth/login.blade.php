<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Healing App</title>

  <!-- Meta -->
  <meta name="description" content="">
  <meta property="og:title" content="Healing App">
  <meta property="og:description" content="">
  <meta property="og:type" content="Website">
  <link rel="shortcut icon" href="{{ url('newadmin') }}/assets/images/favicon.svg">

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ url('newadmin') }}/assets/fonts/remix/remixicon.css">
  <link rel="stylesheet" href="{{ url('newadmin') }}/assets/css/main.min.css">
</head>

<body class="login-bg">

  <!-- Container starts -->
  <div class="container">

    <!-- Auth wrapper starts -->
    <div class="auth-wrapper">

      <!-- Form starts -->
      <form class="auth-form" action="{{ url('/loginSubmit') }}" method="POST">
        @csrf
        <div class="auth-box">

          <!-- Logo / Heading -->
          <a href="#" class="auth-logo mb-4">
            <h5>Healing App</h5>
          </a>
          <h4 class="mb-4">Login</h4>

          <!-- Success Message -->
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

        
          <!-- Phone Input -->
          <div class="mb-3">
            <label class="form-label" for="phone">Your mobile number <span class="text-danger">*</span></label>
            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone') }}" placeholder="Enter your phone number">
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Password Input -->
          <div class="mb-2">
            <label class="form-label" for="password">Your password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password">
              <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                <i class="ri-eye-line text-primary" id="toggleIcon"></i>
              </button>
            </div>
            @error('password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex justify-content-end mb-3">
          </div>
          <div class="mb-3 d-grid gap-2">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>

        </div>
      </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("ri-eye-line");
        toggleIcon.classList.add("ri-eye-off-line");
      } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("ri-eye-off-line");
        toggleIcon.classList.add("ri-eye-line");
      }
    }
  </script>
</body>
</html>
