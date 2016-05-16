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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" title="Sub message add" href="{{ route('sub-message.add-index',$message_id.'/'.$campaign_id) }}">
                    <b>Add Sub-Message</b>
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
                <div class="adv-table">
                    {{-------------- Filter :Starts -------------------------------------------}}
                    {!! Form::open(['route' => 'sub-message.index',$message_id]) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('sub_message_filter_title', Input::old('sub_message_filter_title'), ['id'=>'sub_message_filter_title','placeholder'=>'Search by title','class' => 'form-control','required']) !!}
                            {!! Form::hidden('message_id',$message_id ) !!}
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
                           {{-- <th> Id </th>--}}
                           {{-- <th> Title </th>--}}
                            <th> Title </th>
                            <th> Description </th>
                            <th> Start Time </th>
                            <th> End Time </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                        <tr class="gradeX">
                            {{--<td>{{$values->id}}</td>--}}
                            {{--<td>{{$values->title}}</td>--}}
                            <td>{{$values->title}}</td>
                            <td>{{$values->description}}</td>
                            <td>{{$values->start_time}}</td>
                            <td>{{$values->end_time}}</td>
                            <td>
                                <a href="{{ route('sub-message.show.data', $values->id) }}" class="btn btn-info btn-xs" title="Sub Message Show" data-toggle="modal" data-target="#etsbModal"><i class="icon-eye-open"></i></a>
                                <a href="{{ route('sub-message.edit', $values->id) }}" class="btn btn-primary btn-xs" title="Sub Message Edit" data-toggle="modal"><i class="icon-edit"></i></a>
                                <a href="{{ route('sub-message.destroy', $values->id) }}" class="btn btn-danger btn-xs" title="Sub Message Delete" onclick="return confirm('Are you sure to Delete?')"><i class="icon-trash"></i> </a>
                                </td>
                        </tr>
                        @endforeach
                    </table>
                    <p>&nbsp;</p>
                    <a class="btn-sm btn-success pull-right" data-toggle="modal" href="{{ route('message.index',$campaign_id) }}">Back To Message</a>
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

<!--script for this page only-->
<!--script for refresh modal ImageView-->
<script type="text/javascript">
    $('#imageView').click(function(e) {
        e.preventDefault();
        $('#imageView')
                .removeData()
    });

    function deleteFile(id){
        var confirm_message = confirm('Are you sure');
        if(confirm_message) {
            var $message_id = id;
            $.ajax({
                url: "{{URL::to('attachment/destroy-file', $message_id)}}" ,
                type: 'GET',
                //data: { id: message_id },
                success: function(response)
                {
                    $( "#"+$message_id+"" ).remove();
                    alert("successfully deleted");
                    
                }
            });
        }

    }

    function deleteImage(id){
        var confirm_message = confirm('Are you sure');
        if(confirm_message) {
            var message_id = $('#deleteFileValue').text();
            $.ajax({
                url: '/sub-message/destroy-file/'+message_id,
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

@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif


@stop