@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        {!!  Form::open(['route' => ['failed-mail/batch-send']]) !!}
        <section class="panel">
            <header class="panel-heading">
                {{ $pageTitle }}
                <a title="Refresh Page" class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ route('failed-mail/index') }}">
                    <b>Refresh</b>
                </a>
                <button type="submit" title="Selected Failed Email Sent" class="btn btn-primary btn-sm pull-right" {{--href="{{ route('failed-mail/batch-send') }}" --}}style="margin-right: 20px;">
                    <b>Batch Email Send</b>
                </button>
                <a title="Delete all send mail failed" class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" onclick="return confirm('Are you sure to delete all !!')" href="{{ route('failed-mail/batch-delete') }}">
                    <b>Batch Delete</b>
                </a>
            </header>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(Session::has('send_email_success'))
                    <?php $send_email_success = \Illuminate\Support\Facades\Session::pull('send_email_success'); ?>
                    @foreach($send_email_success as $success)
                        <div class="alert alert-success">
                            <p>{{ $success }}</p>
                        </div>
                    @endforeach
            @endif

            @if(Session::has('send_email_error'))
                    <?php $send_email_error = \Illuminate\Support\Facades\Session::pull('send_email_error'); ?>
                    @foreach($send_email_error as $err)
                        <div class="alert alert-danger">
                            <p>{{ $err }}</p>
                        </div>
                    @endforeach
            @endif

            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('flash_message_error') }}</p>
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

                    {{-------------- Backend Search :Starts -------------------------------------------}}
                    {{--{!! Form::open(['route' => 'failed-mail/index']) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('failed_mail_filter', Input::old('failed_mail_filter'), ['id'=>'failed_mail_filter','placeholder'=>'Search by name','class' => 'form-control','required']) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}--End----------}}
                    <div class="col-md-12">
                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th><input name="id" type="checkbox" id="checkbox" class="selectall" value=""></th>
                            <th>NOT</th>
                            <th>Campaign</th>
                            <th>From Email</th>
                            <th>Password</th>
                            <th>To Email</th>
                            <th>Host</th>
                            <th>Subject</th>
                            <th>Error Msg</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                            <tr class="gradeX">
                                <td><input type="checkbox" name="send_failed_ids[]"  class="myCheckbox" value="{{ $values->id }}" id="select-all"></td>
                                <td>{{ isset($values->no_of_try)?$values->no_of_try:'' }}</td>
                                <td>{{ isset($values->relCampaign->name)?$values->relCampaign->name:'' }}</td>
                                <td>{{ isset($values->from_email)?$values->from_email:'' }}</td>
                                <td>{{ isset($values->password)?$values->password:''  }}</td>
                                <td title="{{ isset($values->to_email)?$values->to_email:'' }}">{{ str_limit(isset($values->to_email)?$values->to_email:'', 30) }}</td>
                                <td>{{ isset($values->host)?$values->host:'' }}</td>
                                <td title="{{ isset($values->subject)?$values->subject:'' }}">{{ str_limit(isset($values->subject)?$values->subject:'', 7) }}</td>
                                <td title="{{ isset($values->msg)?$values->msg:'' }}">{{ str_limit(isset($values->msg)?$values->msg:'', 7) }}</td>
                                <td>
                                    <a href="{{ route('failed-mail/single-send', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" title="Resend Failed Email"><i class="icon-mail-forward"></i></a>
                                    <a href="{{ route('failed-mail/destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete')" title="Mail Delete"><i class="icon-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
                    </div>
                </div>
            </div>
        </section>
        {!! Form::close() !!}
    </div>
</div>

<!-- page end-->

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
<script>
    $('.selectall').click(function() {
        $('#display-btn').show();
        if ($(this).is(':checked')) {
            $('div input').attr('checked', true);
        } else {
            $('div input').attr('checked', false);
        }
    });
    $('.myCheckbox').click(function() {
        $('#display-btn').show();
    });
</script>

@stop