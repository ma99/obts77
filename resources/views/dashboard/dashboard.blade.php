@extends('layouts.dashboard')

{{-- Same dashboard for all types of user --}}
@section('content')
    <dashboard :user="{{ json_encode($role) }}" />
@endsection
