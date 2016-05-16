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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <strong>Add Message-Followup</strong>
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
                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Html</th>
                            <th>Delay </th>
                            {{--<th>Order </th>--}}
                            <th>Sub Message Followup </th>
                            <th>Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{isset($values->campaign_id)?$values->relCampaign->name:''}}</td>
                                    <td>{{isset($values->html)?ucfirst($values->html):''}}</td>
                                    <td>{{isset($values->delay)?$values->delay:''}}</td>
                                    {{--<td>{{isset($values->order)?$values->order:''}}</td>--}}
                                    <td>
                                        <a href="{{ route('sub-message-followup.index', ['message_followup_id'=>$values->id,'campaign_id'=>$values->campaign_id])  }}" class="btn btn-xs btn-primary" title="Sub message Followup">Sub Message Followup</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('message-followup.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Message Followup View"><i class="icon-eye-open"></i></a>
                                        <a href="{{ route('message-followup.edit', $values->id) }}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#etsbModal" title="Message Followup Edit"><i class="icon-edit"></i></a>
                                        <a href="{{ route('message-followup.destroy', $values->id) }}" class="btn btn-danger btn-xs" title="Message Followup Delete" onclick="return confirm('Are you sure to Delete?')"><i class="icon-trash"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>

                    <p>&nbsp;</p>
                    <a class="btn-sm btn-success pull-right" href="{{ URL::route('campaign.index')}}"> <i class="fa fa-arrow-circle-left"></i> Back To Campaign</a>
                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
                </div>
            </div>

        </section>
    </div>
</div>
<!-- page end-->




<!-- addData -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Message-Followup</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'message-followup.store','files'=>true]) !!}
                @include('message_followup._form')
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

    $(function(){
        $('#deleteFile').click(function() {
            alert("OK");
        });
    });
    function deleteFile(id){
        var confirm_message = confirm('Are you sure');
        if(confirm_message) {

            var message_id = id;
            $.ajax({
                url: '/message-followup/destroy-file/'+message_id,
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