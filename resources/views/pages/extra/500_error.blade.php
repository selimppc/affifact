@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <section class="error-wrapper">
        <i class="icon-500"></i>
        <h1>Ouch!</h1>
        <h2>500 Page Error</h2>
        <p class="page-500">Looks like Something went wrong. <a href="index.html">Return Home</a></p>
    </section>
@stop