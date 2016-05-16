@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $pageTitle }}
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <b>Add Popping Email</b>
                </a>
            </header>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('flash_message') }}</p>
                </div>
            @endif

            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('flash_message_error') }}</p>
                </div>
            @endif

            <div class="panel-body">
                <div class="adv-table">

                    {{-------------- Filter :Starts -------------------------------------------}}
                    {!! Form::open(['route' => 'popping_email.index']) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('popmail_filter', Input::old('popmail_filter'), ['id'=>'popmail_filter','placeholder'=>'Search by name','class' => 'form-control','required']) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}


                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Smtp</th>
                            <th>Imap</th>
                            <th>Campaign</th>
                            <th>Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                            <tr class="gradeX">
                                <td>{{ isset($values->name)?$values->name:'' }}</td>
                                <td>{{ isset($values->email)?$values->email:''  }}</td>
                                <td>{{ isset($values->relSmtp->name)?$values->relSmtp->name:'' }}</td>
                                <td>{{ isset($values->relImap->name)?$values->relImap->name:'' }}</td>
                                <td>{{ isset($values->relCampaign_name->name)?$values->relCampaign_name->name:'' }}</td>
                                <td>
                                    <a href="{{ route('popping_email.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Popping Email View"><i class="icon-eye-open"></i></a>
                                    <a href="{{ route('popping_email.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" title="Popping Email Edit"><i class="icon-edit"></i></a>
                                    <a href="{{ route('popping_email.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Popping Email Delete"><i class="icon-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>

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
                <h4 class="modal-title">Add Popping Email</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'popping_email.store']) !!}
                @include('popping_email._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

<!-- modal -->

<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<!-- modal -->
<!-- Modal for delete -->
<div class="modal fade " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <strong>Are you sure to delete?</strong>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>

            </div>
        </div>
    </div>
</div>





<!--script for this page only-->
@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif

@stop