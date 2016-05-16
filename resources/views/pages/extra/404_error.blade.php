@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <section class="error-wrapper">
        <i class="icon-404"></i>
        <h1>404</h1>
        <h2>page not found</h2>
        <p class="page-404">Something went wrong or that page doesn’t exist yet. <a href="index.html">Return Home</a></p>
    </section>
@stop    