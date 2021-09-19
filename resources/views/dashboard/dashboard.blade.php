@extends('layouts.dashboard')

{{-- Same dashboard for all types of user --}}
@section('content')
    <dashboard 
        home-route="{{ route('welcome') }}"
        logout-route="{{ route('logout') }}"
        {{-- :user="{{ json_encode($role) }}"  --}}
        role=@json($role) 
        user=@json($user) 
    />
@endsection
