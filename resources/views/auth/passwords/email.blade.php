@extends('layouts.app')

@section('content')
  
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">{{ __('You forgot your password? Here you can easily retrieve a new password.') }}</p>

      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

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

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Request new password') }}
            </button>
          </div>          
        </div>
      </form>      
    </div>
    <!-- /.login-card-body -->
    <div class="card-footer">
      <p class="mb-1">
        @if (Route::has('password.request.phone'))
            <a href="{{ route('password.request.phone') }}" class="text-center">
                {{ __('Request password by phone?') }}
            </a>
        @endif
      </p>            
    </div>
  </div>
</div>
<!-- /.login-box -->
@endsection

@section('scripts')
<script>
    document.body.classList.add('hold-transition', 'login-page');
  </script>
@endsection