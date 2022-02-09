@extends('layouts.app')

@section('content')
  
<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('welcome') }}"><b>Admin</b>LTE</a>
  </div>
  @if (session('status'))              
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}                    
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">
        {{ __('A verification code has been sent to your phone. Please enter the code below.') }}
      </p>      

      <form method="POST" action="{{ route('password.verify.phone') }}">
        @csrf
        
        <div class="form-group my-2">
          <input type="hidden" name="phone" value="{{ $phone }}">
          <input id="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" type="text" placeholder="Type code here" required autofocus>

          @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
          @endif
        </div>

        <div class="row mb-2 mt-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Verify phone') }}
            </button>
          </div>          
        </div>
      </form>            

      <form method="POST" action="{{ route('password.send.sms') }}">
        @csrf                                
        <div class="form-group my-2">
            <input type="hidden" name="phone" value="{{ $phone }}">
            <div class="row ">
              <div class="col-12">
                <button type="submit" class="btn btn-warning btn-block">
                    {{ __('Resend code') }}
                </button>
              </div>          
            </div>
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
<!-- /.login-box -->
@endsection

@section('scripts')
<script>
    document.body.classList.add('hold-transition', 'login-page');
  </script>
@endsection