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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <b>Add Message</b>
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
                            <th> Campaign name </th>
                            <th> html </th>
                            <!-- order add later for reorder message-->
                            <th> Order </th>
                            <th> Delay </th>
                            <th> Sub Message </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                        <tr class="gradeX">
                            <td>{{$values->relCampaign->name}}</td>
                            <td>{{$values->html}}</td>
                            <td> Message  {{$values->order}}</td>
                            <td>{{$values->delay}}</td>
                            <td>
                                <a href="{{ route('sub-message.index',['message_id'=>$values->id,'campaign_id'=>$values->campaign_id]) }}" class="btn btn-default btn-xs">Sub Message</a>
                            </td>
                            <td>
                                <a href="{{ route('message.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Message View"><i class="icon-eye-open"></i></a>
                                <a href="{{ route('message.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" title="Message Edit"><i class="icon-edit"></i></a>
                                <a href="{{ route('message.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Message Delete"><i class="icon-trash"></i></a>
                                </td>
                        </tr>
                        @endforeach

                    </table>
                    <p>&nbsp;</p>
                    <a class="btn-sm btn-success pull-right" data-toggle="modal" href="{{ route('campaign.index') }}">Back To Campaign</a>
                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
                </div>
            </div>

        </section>
    </div>
</div>
<!-- page end-->




<!-- addIMAP -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Message</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'message.store']) !!}
                    @include('message._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<!-- modal -->



<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<!-- modal -->


<!--script for this page only-->
<script>
    function numberRange() {
        var x, text;

        // Get the value of the input field with id="numb"
        x = document.getElementById("delay").value;

        // If x is Not a Number or less than one or greater than 10
        if (x >= 256) {
            text = "<p class='help-block'>The delay may not be greater than 255</p>";
            document.getElementById("message_submit").disabled = true;
        }
        else{
            text = '';
            document.getElementById("message_submit").disabled = false;
        }
        document.getElementById("delay-error").innerHTML = text;
    }
</script>
@stop