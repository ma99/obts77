@extends('layouts.app')

@section('content')

    <example-component v-slot="vm">
    	@{{vm.msg}}
    	Number: @{{vm.number}}
    	Square: @{{vm.numberSquare }}
    	<br>
    	 <button type="button" class="btn btn-outline-primary" v-on:click.prevent="vm.increaseNumber()">Number++</button>

    </example-component>
    {{-- <example-event />	 --}}

@endsection