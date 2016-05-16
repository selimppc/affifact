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
                    <p id='error_blanck'></p>
                </div>
            @endif
            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('flash_message_error') }}</p>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Customer Mails</strong>
                        </header>
                        <p> &nbsp; </p>
                        {!! Form::open(['route' => 'system-clean.system_wise_delete','onsubmit'=>"return validation()"]) !!}
                        <div class="col-sm-12">
                            <div class="col-lg-4" style="padding-top: 3px">
                                {!! Form::label('task', 'Delete customer mails older than') !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::text('custom_days', Input::old('custom_days'), ['id'=>'custom_days','class' => 'form-control','placeholder'=>'']) !!}
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
                        <p> &nbsp; </p><p> &nbsp; </p>
                    </section>
                    <hr>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Sender Email For Mailserver</strong>
                        </header>
                        <p> &nbsp; </p>
                        {!! Form::open(['route' => 'system-clean.sender_mail_delete','onsubmit'=>"return validation2()"]) !!}

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
                        <p> &nbsp; </p><p> &nbsp; </p>
                    </section>
                    <hr>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->

<script>

    function validation()
    {
        var day= $('#custom_days').val();
        if(day=='')
        {
            $('#message').html('Please insert a value.').css('color', 'red');
            return false;
        }
        else
        {
            return confirm('Are you sure to Delete?');
        }
    }

    function validation2()
    {
        var hosts= $('#host').val();
        if(hosts=='')
        {
            $('#message2').html('Please select a host.').css('color', 'red');
            return false;
        }
        else
        {
            return confirm('Are you sure to Delete?');
        }
    }


</script>

<!--script for this page only-->
@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif

@stop