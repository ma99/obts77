@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 bg-darkblue shadow">
                
                <div class="card-header bg-info text-white">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right font-weight-normal">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                      </div>
                                    </span>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                                    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right font-weight-normal">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-mobile-alt"></i>
                                      </div>
                                    </span>
                                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                                
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right font-weight-normal">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                      </div>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right font-weight-normal">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-unlock"></i>
                                      </div>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right font-weight-normal">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-unlock-alt"></i>
                                      </div>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary-light btn-block border-rounded">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
