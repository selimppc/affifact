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


                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ URL::to('email-queue-process') }}" title="Generate Queued Emails from Popped Message ">
                    <b> Create Email Queue (Manually)  </b>
                </a>
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





            <div class="panel-body">
                <a class="btn-sm btn-info" data-toggle="modal" href="{{ URL::to('bulk_mail_queue_reply') }}" title="Send Email upto Now (Time)">
                    <b> Send Email (Manually)  </b>
                </a>
                <div class="adv-table">

                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th> Popped message (id) </th>
                            <th> Followup message (id) </th>
                            <th> Send time </th>
                            <th> Sender email </th>
                            <th> To email </th>
                            {{--<th> Action </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($followup_data))
                            @foreach($followup_data as $values)
                                <tr class="gradeX">
                                    <td>{{ $values->popped_message_header_id }}</td>
                                    <td>{{ $values->followup_sub_message_id }}</td>
                                    <td>{{ $values->send_time }}</td>
                                    <td>{{isset($values->sender_email_id)? $values->sender_email_id : ""}}</td>
                                    <td>{{$values->to_email}}</td>
                                    {{--<td>
                                        <a href="{{ route('mail_queue_reply', $values->id) }}" class="btn btn-info btn-xs"><b>Reply Email </b></a>
                                    </td>--}}
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <span class="pull-right">{!! str_replace('/?', '?', $followup_data->render()) !!} </span>
                </div>
            </div>

        </section>
    </div>
</div>
<!-- page end-->


@stop