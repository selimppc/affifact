@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

        <!-- page start-->
<section class="panel">
    <header class="panel-heading">
        xCharts Basic Example
    </header>
    <div class="panel-body">
        <figure class="demo-xchart" id="chart"></figure>
    </div>
</section>
<!-- page end-->
@stop    