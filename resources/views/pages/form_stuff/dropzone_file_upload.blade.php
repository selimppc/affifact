@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

        <!-- page start-->
<section class="panel">
    <header class="panel-heading">
        Dropzone File Upload
    </header>
    <div class="panel-body">
        <form action="assets/dropzone/upload.php" class="dropzone" id="my-awesome-dropzone"></form>
    </div>
</section>
<!-- page end-->
@stop