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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ route('sub-message-followup.add-index',$campaign_id.'/'.$message_followup_id) }}" title="Add Followup Sub message">
                    <strong>Add Followup Submessage</strong>
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
            @if(Session::has('error_message'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error_message') }}</p>
                </div>
            @endif
            <div class="panel-body">
                <div class="adv-table">
                    <p> &nbsp; </p>
                    {{-------------- Filter :Starts -------------------------------------------}}
                    {{--{!! Form::open(['route' => 'sub-message-followup.index',$campaign_id,$message_followup_id]) !!}--}}
                    {{--route('sub-message-followup.index', ['message_followup_id'=>$values->id,'campaign_id'=>$values->campaign_id])--}}
                    {{--<div class="col-sm-8">--}}

                        {{--<div class="col-sm-5">--}}
                            {{--{!!Form::text('title', Input::old('title'), ['class' => 'form-control','placeholder'=>'Filter By title']) !!}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2" style="padding-top: 1%">--}}
                            {{--{!! Form::submit('Filter', array('class'=>'btn btn-info btn-xs','id'=>'button')) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--{!! Form::close() !!}--}}
                    {{--<p> &nbsp; </p><p> &nbsp; </p>--}}
                    {{-------------- Filter :Ends -------------------------------------------}}
                    {{-------------- Filter :Starts -------------------------------------------}}
                    {!! Form::open(['route' => 'sub-message-followup.index',$campaign_id,$message_followup_id]) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('sub_message_followup_filter_title', Input::old('sub_message_filter_title'), ['id'=>'sub_message_followup_filter_title','placeholder'=>'Search by title','class' => 'form-control','required']) !!}
                            {!! Form::hidden('campaign_id',$campaign_id ) !!}
                            {!! Form::hidden('message_followup_id',$message_followup_id ) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    {{-------------- Filter :Ends -------------------------------------------}}
                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            {{--<th>title</th>--}}
                            <th>Title </th>
                            <th>Description </th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    {{--<td>{{isset($values->title)?$values->title:''}}</td>--}}
                                    <td>{{$values->title}}</td>
                                    <td>{{isset($values->description)?$values->description:''}}</td>
                                    <td>{{isset($values->start_time)?$values->start_time:''}}</td>
                                    <td>{{isset($values->end_time)?$values->end_time:''}}</td>
                                    <td>
                                        <a href="{{ route('sub-message-followup.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Followup Sub Message Show"><i class="icon-eye-open"></i></a>
                                        <a href="{{ route('sub-message-followup.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" title="Followup Sub Message Edit"><i class="icon-edit"></i></a>
                                        <a href="{{ route('sub-message-followup.destroy', $values->id) }}" class="btn btn-danger btn-xs" title="Followup Sub Message Delete" onclick="return confirm('Are you sure to Delete?')"><i class="icon-trash"></i></a>
                                    </td>
                                </tr>
                        @endforeach
                        @endif
                    </table>

                    <p>&nbsp;</p>
                    <a class="btn-sm btn-success pull-right" href="{{ URL::route('message-followup.index',['campaign_id'=>$campaign_id])}}"> <i class="fa fa-arrow-circle-left"></i> Back To Message Followup</a>
                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
                </div>
            </div>

        </section>
    </div>
</div>
<!-- page end-->

<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<!-- modal -->

<!-- View image for sub message attachment in Modal  -->
<div class="modal fade" id="imageView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background-color: #1a1a1a; margin: 0 auto; opacity: 0.9">
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
<script type="text/javascript">
    $('#imageView').click(function(e) {
        e.preventDefault();
        $('#imageView')
                .removeData()
    });

    function deleteFile(id){
        var confirm_message = confirm('Are you sure');
        if(confirm_message) {
            var message_id = id;
            $.ajax({
                url: '/sub-message-followup/destroy-file/'+message_id,
                type: 'GET',
                //data: { id: message_id },
                success: function(response)
                {
                    $( "#"+message_id+"" ).remove();
                    alert("successfully deleted");

                    //$('#something').html(response);
                }
            });
        }

    }
</script>

@stop