@extends('layouts.dashboard')

{{-- Same dashboard for all types of user --}}
@section('content')
    <dashboard 
        home-route="{{ route('welcome') }}"
        logout-route="{{ route('logout') }}"
        {{-- :user="{{ json_encode($role) }}"  --}}
        role=@json($role) 
        token=@json($token) 
        user="{{$user}}"
    />
        {{-- user=@json($user)  --}}
@endsection
