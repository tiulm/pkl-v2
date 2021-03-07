<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIMON | Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <div class="text-center">
        <img src="/public/image/profile.png"><br>
        <a href="#">
          <b>S</b>IMON PKL-PK
        </a>
      </div>
    </div>
    <div class="card card-primary">
      <div class="card-header">
        <h5 class="card-title">
          <i class="fas fa-sign-in-alt mr-1"></i>
          Sign in
        </h5>
      </div>
      <form action="{{ route('login') }}" method="POST">
        <div class="card-body">
          @csrf
          <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <div class="input-group">
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="identity" value="{{ old('username') }}" required autocomplete="username" autofocus>
              @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <div class="input-group">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right">Sign In</button>
        </div>
      </form>
    </div>
  </div>
  </div>

  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>

</body>

</html>