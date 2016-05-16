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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="{{ route('sender-email/inactive-email',$campaign_id_single) }}">
                    <strong>Inactive Sender Email</strong>
                </a>
                <span class="pull-right" >
                    <a class="btn-sm btn-success paste-blue-button-bg" data-toggle="modal" href="#GenerateEmail" >{{-- {{ route('generate.email') }}--}}
                        Generate Email(Manually using cpanel)
                    </a>
                    <a class="btn-sm btn-success paste-blue-button-bg" data-toggle="modal" href="#addData" >
                        Add E-mail
                    </a>
                    <a class="btn-sm btn-success paste-blue-button-bg" data-toggle="modal" href="#bulkEmail" >
                        Import from CSV File
                    </a>
                </span>

                <span class="pull-right" >
                    <a class="btn-sm btn-success paste-blue-button-bg" data-toggle="modal" href="{{route('set_max_email_send')}}" >
                        SET MAX Email Send
                    </a>
                </span>

                {{--<a class="btn-sm btn-success" data-toggle="modal" href="#addUserData" style="color: black">
                    Generate User(Locally)
                </a>--}}

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
            @if(Session::has('error_message'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error_message') }}</p>
                </div>
            @endif


            <div class="panel-body">
                <div class="adv-table">


                    {{-------------- Filter :Starts -------------------------------------------}}

                    {!! Form::open(array('url' => 'sender-email/index/'.$campaign_id_single)) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('sendermail_filter', Input::old('sendermail_filter'), ['id'=>'sendermail_filter','placeholder'=>'Search by name','class' => 'form-control','required']) !!}
                            {!! Form::hidden('campaign_id_single',$campaign_id_single ) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    {{--{!! Form::open(array('url' => '')) !!}--}}
                     <table  class="display table table-bordered table-striped" id="data-table-example">
                         <thead>
                         <tr>
                             <th>Campaign</th>
                             <th>Name</th>
                             <th>Email</th>
                             <th>Password</th>
                             <th>Smtp</th>
                             <th>Imap</th>
                             <th>Max Email Send</th>
                             <th>Popping Status</th>
                             <th>Status</th>
                             <th><a href="#" class="btn btn-info btn-xs" data-toggle="modal" title="Mail Type"><i class="icon-envelope"></i></a></th>
                             <th>Action </th>
                         </tr>
                         </thead>
                         <tbody>

                             @if(isset($data))
                                 @foreach($data as $values)
                                     <tr class="gradeX">
                                         {{--<td><input type="checkbox" name="ids[]"  class="myCheckbox" value="{{ $values->id }}"></td>--}}

                                         <td>{{isset($values->relCampaign->name)?$values->relCampaign->name:''}}</td>
                                         <td>{{isset($values->name)?$values->name:''}}</td>
                                         <td>{{isset($values->email)?$values->email:''}}</td>
                                         <td>{{isset($values->password)?$values->password:''}}</td>
                                         <td>{{isset($values->relSmtp->name)?$values->relSmtp->name:''}}</td>
                                         <td>{{isset($values->relImap->name)?$values->relImap->name:''}}</td>
                                         <td>{{isset($values->max_email_send)?$values->max_email_send:''}}</td>
                                         <td>{{isset($values->popping_status)?ucfirst($values->popping_status):''}}</td>
                                         <td>{{isset($values->status)?$values->status:''}}</td>
                                         @if($values->type=='not-generated')
                                             <td><a href="#" class="btn btn-warning btn-xs" data-toggle="modal" title="{{$values->type}}"><i class="icon-bookmark-empty"></i></a></td>
                                         @else
                                             <td><a href="#" class="btn tn-success btn-xs" data-toggle="modal" title="{{$values->type}}"><i class="icon-book"></i></a></td>
                                         @endif
                                         <td>
                                             <a href="{{ route('sender-email.check-sender-email', $values->id) }}" class="btn btn-info btn-xs" title="Check Email Status"><i class="icon-check"></i></a>
                                             <a href="{{ route('sender-email.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Sender Email View"><i class="icon-eye-open"></i></a>
                                             <a href="{{ route('sender-email.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" title="Sender Email Edit"><i class="icon-edit"></i></a>

                                             {{--If generated then delete in server --}}
                                             {{--@if($values->type == "generated")
                                                 <a href="{{ route('delete.email.cpanel',['email'=>$values->email,'id'=>$values->id,'campaign_id'=>$campaign_id_single]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Sender Email Delete"><i class="icon-trash"></i></a>
                                             @else--}}
                                             <a href="{{ route('sender-email.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')"><i class="icon-trash" title="Sender Email Delete"></i></a>
                                             {{--@endif--}}

                                         </td>
                                     </tr>
                                 @endforeach
                              @endif
                         </tbody>
                             {!! Form::submit('Delete Items', array('class'=>'btn btn-xs btn-danger', 'id'=>'hide-button','style'=>"display:none"))!!}

                         </table>
                        {!! Form::close() !!}

                        <p>&nbsp;</p>
                        <a class="btn-sm btn-success pull-right" data-toggle="modal" href="{{ route('campaign.index') }}">Back To Campaign</a>
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
                <h4 class="modal-title">Add Sender Email</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'sender-email.store']) !!}
                @include('sender_email._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

<!-- modal -->

<!-- addUserData -->

<div class="modal fade" id="addUserData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Data</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'sender-email.create-user']) !!}
                @include('sender_email._user_form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

<!-- modal -->

<!-- Generate Sender Email -->

<div class="modal fade" id="GenerateEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Generate Sender Email</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'generate.email']) !!}
                @include('sender_email._user_form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

<!-- modal -->


<!-- bulkEmali -->

<div class="modal fade" id="bulkEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import From Csv File</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route'=> ['bulk.email'], 'method' => 'patch', 'role' => 'form', 'files' => true,])!!}
                @include('sender_email._csv_form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

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


@stop