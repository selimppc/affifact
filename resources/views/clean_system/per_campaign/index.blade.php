@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')

        <!-- page start-->
<div class="center-block row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading text-center">
                <b style="font-size:x-large">{{ $pageTitle }}</b>
            </header>

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

            <div class="row">
                <div class="col-sm-12">
                    {{--system -wide--}}
                    <section class="panel">
                        <header class="panel-heading text-center">
                            system wise
                        </header>
                        <p> &nbsp; </p>
                        {!! Form::open(['route' => 'system-clean.system-wise-delete','onsubmit'=>"return validation_customer_mails(event)"]) !!}
                        <div class="col-sm-12">
                            <div class="col-lg-4" style="padding-top: 3px">
                                {!! Form::label('task', 'Delete customer mails older than') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::number('custom_days', Input::old('custom_days'), ['id'=>'custom_days','class' => 'form-control','placeholder'=>'']) !!}
                                <span id='message'></span>
                            </div>

                            <div class="col-lg-2" style="padding-top: 3px">
                                {!! Form::label('task', 'days') !!}
                            </div>
                            <div class="col-sm-2" style="margin-left: 30px">
                                {!! Form::submit('Delete', array('class'=>'btn btn-success btn-sm','id'=>'button')) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{--mailserver--}}
                        <p> &nbsp; </p><p> &nbsp; </p>
                        {!! Form::open(['route' => 'system-clean.sender-mail-delete','onsubmit'=>"return validation_smtp_mails()"]) !!}

                        <div class="col-sm-12">
                            <div class="col-lg-4" style="padding-top: 3px">
                                {!! Form::label('task', 'Delete sender mails for mailserver') !!}
                            </div>
                            <div class="col-sm-4">
                                {!!Form::select('host', $smtp_host, Input::old('host'), ['id'=>'host','class' => 'form-control','placeholder'=>'Please Select']) !!}
                                <span id='message2'></span>
                            </div>
                            <div class="col-sm-2" style="margin-left: 30px">
                                {!! Form::submit('Delete', array('class'=>'btn btn-success btn-sm','id'=>'button')) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{----}}
                        <p> &nbsp; </p><p> &nbsp; </p>
                    </section>
                    <hr>
                    {{--system -wide:end--}}

                    {{--Per Campaign--}}
                    <section class="panel">
                        <header class="panel-heading text-center">
                            Per Campaign
                        </header>
                        <p> &nbsp; </p>
                        {!! Form::open(['route' => 'clean-system.per-campaign.delete','onsubmit'=>"return validation_customer_campn_mails()"]) !!}
                            <div class="col-sm-12">
                                <div class="col-lg-3" style="padding-top: 3px">
                                    {!! Form::label('text', 'Delete Customer Mails Older Than') !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::number('days', Input::old('days'), ['id'=>'days','class' => 'form-control','placeholder'=>'']) !!}
                                    <span id='message3'></span>
                                </div>
                                <div class="col-lg-2" style="padding-top: 3px">
                                    {!! Form::label('text', 'Days For Campaign') !!}
                                </div>
                                <div class="col-sm-2">
                                    {!!Form::select('campaign_id', $campaign_id, Input::old('campaign_id'), ['id'=>'campaign_id','class' => 'form-control','placeholder'=>'Please Select']) !!}
                                    <span id='message4'></span>
                                </div>
                                <div class="col-sm-2" style="margin-left: 80px">
                                    {!! Form::submit('Delete', array('class'=>'btn btn-success btn-sm','id'=>'button')) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                        {{--mailserver--}}
                        <p> &nbsp; </p><p> &nbsp; </p>
                        {!! Form::open(['route' => 'clean-system.delete.mail-server','onsubmit'=>"return validation_smtp_campn_mails()"]) !!}
                        <div class="col-sm-12">
                            <div class="col-lg-2" style="padding-top: 3px">
                                {!! Form::label('text', 'Delete Sender Mails For MailServer') !!}
                            </div>
                            <div class="col-sm-3">
                                {!!Form::select('host', $smtp_host, Input::old('host'), ['id'=>'host2','class' => 'form-control','placeholder'=>'Please Select']) !!}
                                <span id='message5'></span>
                            </div>
                            <div class="col-lg-2" style="padding-top: 3px">
                                {!! Form::label('text', 'For Campaign') !!}
                            </div>
                            <div class="col-sm-2">
                                {!!Form::select('campaign_id', $campaign_id, Input::old('campaign_id'), ['id'=>'campaign_id2','class' => 'form-control','placeholder'=>'Please Select']) !!}
                                <span id='message6'></span>
                            </div>
                            <div class="col-sm-2" style="margin-left: 80px">
                                {!! Form::submit('Delete', array('class'=>'btn btn-success btn-sm','id'=>'button')) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{--Per Campaign:end--}}
                        <p> &nbsp; </p><p> &nbsp; </p>
                    </section>

                    <hr>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->



<!--script for this page only-->



<script>

    function validation_customer_mails(event)
    {
        var day= $('#custom_days').val();
        if(day==''){ $('#message').html('Please insert a value.').css('color', 'red'); return false; }
        else{  return confirm('Are you sure to Delete?'); }
    }
    function validation_smtp_mails()
    {
        var hosts= $('#host').val();
        if(hosts==''){  $('#message2').html('Please select a host.').css('color', 'red');return false; }
        else{ return confirm('Are you sure to Delete?'); }
    }
    function validation_customer_campn_mails()
    {
        var days= $('#days').val();
        var camp_id= $('#campaign_id').val();
        if(days==''){  $('#message3').html('Please insert a value.').css('color', 'red');return false; }
        else if(camp_id==''){  $('#message4').html('Please select a Campaign.').css('color', 'red');return false; }
        else{ return confirm('Are you sure to Delete?'); }
    }
    function validation_smtp_campn_mails()
    {
        var hostss= $('#host2').val();
        var camp_id2= $('#campaign_id2').val();

        if(hostss==''){  $('#message5').html('Please select a host.').css('color', 'red');return false; }
        else if(camp_id2==''){  $('#message6').html('Please select a Campaign.').css('color', 'red');return false; }
        else{ return confirm('Are you sure to Delete?'); }
    }

</script>



@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif

@stop