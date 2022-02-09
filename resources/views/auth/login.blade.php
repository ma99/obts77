@extends('layouts.app')

@section('content')
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form action="{{ route('login') }}" method="POST">
            @csrf  
            <div class="input-group mb-3">
              <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>

              @error('phone')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="input-group mb-3">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="row">
              <div class="col-8">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label font-weight-bold" for="remember">Remember Me</label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <!-- <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div> -->
          <!-- /.social-auth-links -->

          {{-- <p class="mb-1">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
          </p>
          <p class="mb-0">          
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-center">
                    {{ __('Register a new membership') }}
                </a>
            @endif
          </p> --}}
        </div>
        <!-- /.login-card-body -->
        <div class="card-footer">
          <p class="mb-1">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
          </p>
          <p class="mb-1">          
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-center">
                    {{ __('Register a new membership') }}
                </a>
            @endif
          </p>          
        </div>
      </div>
  </div>
@endsection

@section('scripts')
<script>
    document.body.classList.add('hold-transition', 'login-page');
  </script>
@endsection
