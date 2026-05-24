@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
<style>
body {
  background: linear-gradient(135deg, #fdf6e3, #fff8dc);
}

.authentication-inner .card {
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
}

.authentication-inner .card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

/* Inputs */
.form-control {
  border-radius: 12px;
  padding: 0.75rem 1rem;
  transition: border 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
}

.form-control:focus {
  border-color: darkkhaki;
  box-shadow: 0 0 0 0.2rem rgba(189, 183, 107, 0.25);
  transform: scale(1.02);
}

/* Icons inside inputs */
.input-group-text {
  background: #f0e68c33;
  border-radius: 0 12px 12px 0;
  cursor: pointer;
  transition: transform 0.2s ease, background 0.2s ease;
}

.input-group-text:hover {
  background: #f0e68c66;
  transform: scale(1.2);
}

/* Buttons */
.btn-login {
  background-color: darkkhaki;
  border-radius: 12px;
  position: relative;
  overflow: hidden;
  transition: background 0.3s ease, transform 0.2s ease;
}

.btn-login:hover {
  background-color: #c0b03e;
  transform: translateY(-2px);
}

/* ripple effect */
.btn-login:active::after {
  content: "";
  position: absolute;
  left: 50%;
  top: 50%;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%) scale(0);
  border-radius: 50%;
  animation: ripple 0.6s linear;
}

@keyframes ripple {
  to {
    transform: translate(-50%, -50%) scale(4);
    opacity: 0;
  }
}

/* Typography */
h4 {
  font-weight: 700;
  color: #5a5a5a;
}

p {
  color: #777;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Login Card -->
      <div class="card px-sm-6 px-0">

        <div class="card-body text-center">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-4">
            <span class="app-brand-logo demo"></span>
            <span class="app-brand-text demo text-heading fw-bold fs-3">Login</span>
          </div>

          <h4 class="mb-1">Welcome Admin! 👋</h4>
          <p class="mb-6">Please sign-in to your account</p>

          <form id="formAuthentication" class="mb-6" method="post" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3 text-start position-relative">
              <label for="email" class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email"
                  autofocus />
              </div>
            </div>

            <!-- Password -->
            <div class="mb-4 text-start form-password-toggle position-relative">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password" />
                <span class="input-group-text toggle-password"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <!-- Login Button -->
            <div class="mb-4">
              <button class="btn btn-login d-grid w-100" type="submit">Login</button>
            </div>
          </form>
        </div>

      </div>
      <!-- /Login Card -->

    </div>
  </div>
</div>

<script>
// Password toggle
document.querySelectorAll('.toggle-password').forEach(function(toggle) {
  toggle.addEventListener('click', function() {
    const input = this.parentElement.querySelector('input');
    const icon = this.querySelector('i');
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove('bx-hide');
      icon.classList.add('bx-show');
    } else {
      input.type = "password";
      icon.classList.remove('bx-show');
      icon.classList.add('bx-hide');
    }
  });
});
</script>
@endsection
