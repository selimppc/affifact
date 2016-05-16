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
                <strong>{{ $pageTitle }}</strong>
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <strong>Add Campaign</strong>
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
                    {!! Form::open(['route' => 'campaign.index']) !!}
                    <div class="col-sm-8">
                        <div class="col-sm-3">
                            {!! Form::text('name', Input::old('name'), ['id'=>'f-name','class' => 'form-control','placeholder'=>'Filter By Name']) !!}
                        </div>

                        <div class="col-sm-5">
                            {!!Form::select('popping_email_id', $popping_email_all, Input::old('popping_email_id'), ['class' => 'form-control','placeholder'=>'Filter By Popping Email']) !!}
                        </div>
                        <div class="col-sm-2" style="padding-top: 1%">
                            {!! Form::submit('Filter', array('class'=>'btn btn-info btn-xs','id'=>'button')) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                    <p> &nbsp; </p><p> &nbsp; </p>
                    {{-------------- Filter :Ends -------------------------------------------}}
                    <table  class="display table table-bordered table-striped" id="data-table-example">

                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Popping Email </th>
                            <th> Status </th>
                            <th> Sender Email </th>
                            <th>Message / Followup</th>
                            <th>Action </th>
                            <th>Change Stat </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                            <tr class="gradeX">
                                <td>{{isset($values->name)?$values->name:''}}</td>
                                <td>{{isset($values->relPoppingEmail->email)?$values->relPoppingEmail->email:''}}</td>
                                <td>{{isset($values->status)? ($values->status):''}}</td>
                                <td>
                                    <a href="{{ route('sender-email.index', $values->id) }}" class="btn btn-info btn-xs">Sender Email</a>
                                </td>


                                <td>
                                    <a href="{{ route('message.index', ['c_id'=>$values->id])  }}" class="btn btn-xs btn-primary" title="Message">Message</a>
                                    <a href="{{ route('message-followup.index', ['campaign_id'=>$values->id])  }}" class="btn btn-xs btn-primary" title="Message-followup">Message Followup</a>
                                </td>

                                <td>
                                    @if($values->status=='inactive')
                                    <a href="{{ route('campaign.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Campaign View"><i class="icon-eye-open"></i></a>
                                    <a href="{{ route('campaign.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" title="Campaign Edit"><i class="icon-edit"></i></a>
                                    <a href="{{ route('campaign.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Campaign Delete"><i class="icon-trash"></i></a>
                                        @endif
                                </td>
                                <td>
                                    @if(isset($values->popping_email_id))
                                    @if($values->status=='active')
                                    <a href="{{ route('inactive.change.stat', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Deactivate ?')">Deactivate</a>
                                     @elseif($values->status=='inactive')
                                        <a href="{{ route('active.change.stat', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Active ?')">Active</a>
                                    @endif
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        @endif
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
                <h4 class="modal-title">Add</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'campaign.store']) !!}
                    @include('campaign._form')
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