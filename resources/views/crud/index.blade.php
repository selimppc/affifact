@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $pageTitle }}
                <a class="btn-sm btn-success pull-right" data-toggle="modal" href="#addData">
                    Add Data
                </a>
            </header>


            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="panel-body">
                <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="example">
                        <thead>
                        <tr>
                            <th> Id </th>
                            <th> Name </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                        <tr class="gradeX">
                            <td>{{$values->id}}</td>
                            <td>{{$values->name}}</td>
                            <td>
                                <a href="{{ route('crud.show.data', $values->id) }}" class="btn btn-info btn-sm" data-toggle="modal" data-target="#etsbModal">View</a>
                                <a href="{{ route('crud.edit', $values->id) }}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#etsbModal">Edit</a>
                                <a href="{{ route('crud.destroy', $values->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->




<!-- addData -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Data</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'crud.store']) !!}
                    @include('crud._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<!-- modal -->



<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-- modal -->


<!--script for this page only-->



@stop