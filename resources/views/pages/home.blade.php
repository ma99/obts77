@extends('layouts.app')

@section('warningbar')
  @include('includes.unverified.phone-warning')                
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">        
      welcome to home page of obts
    </div>
     {{--  <seat cities= "{{ $cities }}" ></seat>        --}}
    <div class="col-12 mt-3">
      {{-- <seat-display :user= "{{auth()->user()}}" /> --}}
      <seat-display
        user=@json($user) 
        phone-verification-route="{{ route('phoneverification.notice') }}" 
        cash-payment-route="{{ route('make.payment.cash') }}" 
        card-payment-route="{{ route('make.payment.card') }}" 
        login-route="{{ route('login') }}" 
        register-route="{{ route('register') }}" 
      />
      {{-- {{ $user }} --}}
      {{-- @json($user) --}}
    </div>      
  </div>
</div>
@endsection