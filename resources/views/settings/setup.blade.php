@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading ">
                    {{ $pageTitle }}
                </header>
            </section>
        </div>
    </div>

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
        <div class="col-lg-12">
             <a href="{{ URL::to('reset_count_mails') }}" class="btn btn-info" title="Reset"> <b>Reset Count  </b></a>
            <a href="{{ URL::to('central-settings') }}" class="btn btn-info" title="Central Settings"> <b>Central Settings </b></a>
            <a href="{{ URL::to('public_domain') }}" class="btn btn-info" title="Public Domain"> <b>Public Domain</b></a>

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ URL::to('combing-clean-level2') }}" class="btn btn-warning" title="Delete Popped message, Email queue, Send Failed and sender email count reset" onclick="return confirm('If you press `OK` then Popped message, Email queue, Mail Thread, Send Failed data shall be deleted and Sender Email count will be reset ?')"> <b>Level 1 Clean Up</b><i class="icon-trash" title="Delete Popped message, Email queue, Send Failed, Mail Thread and Sender Email count reset"></i></a>
            <span class="label label-danger">NOTE!</span><span>Delete Only Popped message, Email queue, Send Failed, Mail Thread and Sender Email count reset</span>
            <br>
            <br>
            <a href="{{ URL::to('combing-clean') }}" class="btn btn-danger" title="Delete All Data From The Entire Application" onclick="return alertTwice();"> <b>Level 2 Clean Up</b><i class="icon-trash" title="Delete All Data"></i></a>
            <span class="label label-danger">NOTE!</span><span>Delete All Data</span>

        </div>
    </div>
    <script>
        function alertTwice() {
            var check1=confirm("If you press `OK` then Campaign, Sender Email, Message, Sub Message, Followup Message, Sub Message Followup, Popped message, Email queue, Mail Thread and Send Failed data shall be deleted \n\nAre you sure??");
            if (check1)
            {
                var check2=confirm("Are you 100% sure?");
                if (check2)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    </script>
@stop