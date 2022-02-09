@extends('layouts.app')

@section('content')
  
<div class="register-box">
  <div class="register-logo">
    <a href="{{route('welcome')}}"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">{{ __('Register a new membership') }}</p>

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group mb-3">
          {{-- <input type="text" class="form-control" placeholder="Full name"> --}}
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Full name" required autocomplete="name" autofocus>                                   
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="input-group mb-3">          
          <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required autocomplete="phone">

          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-phone"></i>
            </div>
          </div>

          @error('phone')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror

        </div>

        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">                                    
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                    
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
        <div class="input-group mb-3">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required autocomplete="new-password">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="agreeTerms" name="terms" value="agree"
              onchange="document.getElementById('btnSubmit').disabled = !this.checked;"
              >
              <label class="custom-control-label font-weight-bold" for="agreeTerms">
                I agree to the <a href="#">terms</a>
              </label>
            </div>            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id="btnSubmit" class="btn btn-primary btn-block" disabled>{{ __('Register') }}
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>      
    </div>
    <!-- /.form-box -->
    <div class="card-footer">
      <p class="mb-1">          
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="text-center">
                {{ __('Already have a membership') }}
            </a>
        @endif
      </p>      
    </div>
  </div><!-- /.card -->
</div>
<!-- /.register-box -->  
@endsection

@section('scripts')
<script>
    document.body.classList.add('hold-transition', 'register-page');
  </script>
@endsection
