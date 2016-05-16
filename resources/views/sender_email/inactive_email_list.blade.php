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
            <header class="panel-heading ">
                {{ $pageTitle }}
                {{--<a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ route('sender-email/inactive-email') }}">--}}
                    {{--<strong>Inactive Sender Email</strong>--}}
                {{--</a>--}}
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


                    {!!  Form::open(['route' => ['sender-email/batch-delete']]) !!}
                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th><input name="id" type="checkbox" id="checkbox" class="selectall" value=""></th>
                            <th>Campaign</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Smtp</th>
                            <th>Imap</th>
                            <th> Max Send Email</th>
                            <th>Status</th>
                            <th><a href="#" class="btn btn-info btn-xs" data-toggle="modal" title="Mail Type"><i class="icon-envelope"></i></a></th>
                            <th>Action </th>
                        </tr>
                        </thead>
                        <span class="input-group-btn"><button class="btn btn-xs btn-danger btn-flat" type="submit" onclick="return confirm('Are you sure to delete')" id='display-btn' style="display: none" title="delete selected one or more sender emails">Delete Sender Email</button></span>
                        <tbody>

                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td><input type="checkbox" name="ids[]"  class="myCheckbox" value="{{ $values->id }}" id="select-all"></td>
                                    <td>{{isset($values->relCampaign->name)?$values->relCampaign->name:''}}</td>
                                    <td>{{isset($values->name)?$values->name:''}}</td>
                                    <td>{{isset($values->email)?$values->email:''}}</td>
                                    <td>{{isset($values->password)?$values->password:''}}</td>
                                    <td>{{isset($values->relSmtp->name)?$values->relSmtp->name:''}}</td>
                                    <td>{{isset($values->relImap->name)?$values->relImap->name:''}}</td>
                                    <td>{{isset($values->max_email_send)?$values->max_email_send:''}}</td>
                                    <td>{{isset($values->status)?$values->status:''}}</td>
                                    @if($values->type=='not-generated')
                                        <td><a href="#" class="btn btn-warning btn-xs" data-toggle="modal" title="{{$values->type}}"><i class="icon-bookmark-empty"></i></a></td>
                                    @else
                                        <td><a href="#" class="btn tn-success btn-xs" data-toggle="modal" title="{{$values->type}}"><i class="icon-book"></i></a></td>
                                    @endif
                                    <td>
                                        @if($values->type == "generated")
                                            <a href="{{ route('delete.email.cpanel',['email'=>$values->email,'id'=>$values->id,'campaign_id'=>$campaign_id_single]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Sender Email Delete"><i class="icon-trash"></i></a>
                                        @else
                                            <a href="{{ route('sender-email.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')"><i class="icon-trash" title="Sender Email Delete"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>

                    </table>
                    {!! Form::close() !!}
                    <p>&nbsp;</p>
                    <a class="btn-sm btn-success pull-right" data-toggle="modal" href="{{ route('sender-email.index',$campaign_id_single) }}">Back To Sender Email</a>
                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>

                </div>
            </div>
        </section>
    </div>
</div>

<!-- page end-->

<!-- addData -->



<!-- modal -->

<!-- addUserData -->


<!-- modal -->

<!-- Generate Sender Email -->



<!-- modal -->


<!-- bulkEmali -->



<!-- modal -->

<!-- Update  -->
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

<!--script for this page only-->

@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif
@if(Session::has('flash_message_error'))
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif
@if(Session::has('flash_message_error_generate'))
    <script type="text/javascript">
        $(function(){
            $("#GenerateEmail").modal('show');
        });
    </script>
@endif

{{-- batch delete --}}
<script>
    $('.selectall').click(function() {
        $('#display-btn').show();
        if ($(this).is(':checked')) {
            $('div input').attr('checked', true);
        } else {
            $('div input').attr('checked', false);
        }
    });
    $('.myCheckbox').click(function() {
        $('#display-btn').show();
    });
</script>


@stop