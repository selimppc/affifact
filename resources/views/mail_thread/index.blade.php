@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')


        <!--mail inbox start-->
<div class="mail-box">

    <aside class="lg-side">
        <div class="inbox-head">
            <h3> Mail Thread </h3>
            <form class="pull-right position" action="#">
                <div class="input-append">
                    <input type="text"  placeholder="Search Mail" class="sr-input">
                    <button type="button" class="btn sr-btn"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>

        <header class="panel-heading">
            {{ $pageTitle }}
            <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ route('mail-thread.inactive-list') }}">
                <strong>Inactive Mail Thread</strong>
            </a>
        </header>


        <div class="inbox-body">
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

            {!!  Form::open(['route' => ['mail-thread.all-destroy']]) !!}

            <table class="table table-inbox table-hover" style="padding: 2px;">
                <thead>
                <tr>
                    <th><input name="id" type="checkbox" id="checkbox" class="checkbox" value="" style="display: none"></th>
                    <th> User Name(User Email)</th>
                    <th> Subject </th>
                    <th> Message Order </th>
                    <th> Campaign ID </th>
                    <th> Action </th>
                </tr>
                </thead>
                <span class="input-group-btn"><button class="btn btn-danger btn-flat" type="submit" onclick="return confirm('Are you sure to delete')">All Delete</button></span>
                <tbody>
                    @if(count($data)>0)
                    @foreach($data as $value)
                        {{--@if(count($value->relPoppedMessageDetail)>0)--}}
                            {{--@foreach($value->relPoppedMessageDetail as $dt)--}}


                        @if($value->status == 'not-queued' && isset($value->message_order)) <tr class="color"> @else <tr class=""> @endif
                            <td><input type="checkbox" name="ids[]"  class="myCheckbox" value="{{ $value->id }}"></td>
                            <td class="view-message  dont-show"> <a href="{{route('mail_detail', $value->id)}}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Mail Thread View"> {{isset($value->user_name)?$value->user_name:''}} {{"<"}}{{isset($value->user_email)?$value->user_email:''}}{{">"}} </a></td>
                            {{--<td class="inbox-small-cells"><i class="icon-star"></i></td>--}}
                            <td class="view-message  dont-show"><a href="{{route('mail_detail', $value->id)}}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Mail Thread View"> {{isset($value->subject)? substr($value->subject, 0,50):''}} </a></td>

                            {{--<td class="view-message  inbox-small-cells"><i class="icon-paper-clip"></i></td>--}}
                            <td class="view-message ">{{isset($value->message_order)?$value->message_order:''}}</td>
                            <td class="view-message dont-show">{{isset($value->campaign_id)?$value->campaign_id:''}}</td>

                            <td>
                                <a href="{{route('mail_detail', $value->id)}}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Mail Thread View"><i class="icon-eye-open"></i></a>
                                <a href="{{ route('mail-thread.destroy', $value->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete')" title="Mail Thread Delete"><i class="icon-trash"></i> </a>
                            </td>
                        </tr>
                            {{--@endforeach--}}
                        {{--@endif--}}

                    @endforeach
                    @endif

                </tbody>
            </table>
            {!! Form::close() !!}
                <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
        </div>
    </aside>
</div>
<!--mail inbox end-->



<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<!-- modal -->

<style>
    .color{
        background-color: #CCCCFF;


    }
</style>

@stop