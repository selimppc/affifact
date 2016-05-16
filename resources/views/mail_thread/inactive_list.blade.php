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

        <header class="panel-heading">Inactive Mail Thread</header>


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

            {!!  Form::open(['route' => ['mail-thread.all-active']]) !!}

            <table class="table table-inbox table-hover">
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
                <span class="input-group-btn"><button class="btn btn-danger btn-flat" type="submit" onclick="return confirm('Are you sure to Active')">All Active</button></span>
                <tbody>
                @if(count($data)>0)
                    @foreach($data as $value)

                        @if($value->status == 'not-queued' && isset($value->message_order)) <tr class="color"> @else <tr class=""> @endif
                            <td><input type="checkbox" name="ids[]"  class="myCheckbox" value="{{ $value->id }}"></td>
                            <td class="view-message  dont-show">{{isset($value->user_name)?$value->user_name:''}} {{"<"}}{{isset($value->user_email)?$value->user_email:''}}{{">"}}</td>
                            {{--<td class="inbox-small-cells"><i class="icon-star"></i></td>--}}
                            <td class="view-message  dont-show">{{isset($value->subject)?$value->subject:''}}</td>

                            {{--<td class="view-message  inbox-small-cells"><i class="icon-paper-clip"></i></td>--}}
                            <td class="view-message ">{{isset($value->message_order)?$value->message_order:''}}</td>
                            <td class="view-message dont-show">{{isset($value->campaign_id)?$value->campaign_id:''}}</td>

                            <td><a href="{{ route('mail-thread.active', $value->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Active')" >Active</a></td>
                        </tr>

                        @endforeach
                        @endif

                </tbody>
            </table>
            {!! Form::close() !!}
                <a class="btn-sm btn-success pull-right" data-toggle="modal" href="{{ route('mail_thread') }}">Back to Active List</a>
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