@extends('layouts.app')

@section('content')
    <div class="login-box">
  <div class="login-logo">
    <a href="{{ route('welcome') }}"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password.</p>

      <form method="POST" action="{{ route('password.update.phone') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">
          <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $phone ?? old('phone') }}" required autocomplete="phone" autofocus>

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
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>          
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Change password') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>      
    </div>
    <!-- /.login-card-body -->
    <div class="card-footer">
      <p class="mb-3">        
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
