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
                {{--<a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ URL::to('imap_email') }}" title="Fetch All Unread Emails from Popped Email">
                    <b> Fetch Email (IMAP) </b>
                </a>--}}
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
                <div class="adv-table">

                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th> Campaign  </th>
                            <th> User Email </th>
                            <th> User Name </th>
                            <th> Subject </th>
                            <th> Message Order </th>
                            {{--<th> Action </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($data))
                                @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{isset($values->relCampaign->name)?$values->relCampaign->name:''}}</td>
                                    <td title="{{ isset($values->user_email)?$values->user_email:'' }}">{{ str_limit(isset($values->user_email)?$values->user_email:'', 30) }}</td>
                                    <td>{{$values->user_name}}</td>
                                    <td title="{{ isset($values->subject)?$values->subject:'' }}">{{ str_limit(isset($values->subject)?$values->subject:'', 30) }}</td>
                                    <td>{{$values->message_order}}</td>
                                    {{--<td>--}}
                                        {{--<a href="{{ route('reply_email', $values->id) }}" class="btn btn-info btn-xs"><b>Reply Email </b></a>--}}
                                    {{--</td>--}}
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




@stop