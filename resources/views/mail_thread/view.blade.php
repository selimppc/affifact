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

<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    <a href="{{ URL::previous() }}" class="btn btn-xs btn-default pull-right" type="button"> x </a>
    <h4 class="modal-title">Mail Thread Details</h4>

</div>
<div class="modal-body">

    <div class="row" style="padding: 20px">
        <p>
        <table class="table table-striped  table-bordered">
            <tr>
                <td> Campaign ::  </td>
                <td>{{ isset($p_hd->relCampaign->name)?$p_hd->relCampaign->name:'' }}</td>
            </tr>
            <tr>
                <td> Subject ::  </td>
                <td>{{ isset($p_hd->subject)?$p_hd->subject:'' }}</td>
            </tr>
        </table>
        <div>
        <small>Mails as below: </small>
        @foreach($p_dt as $dt)


                @if(count($dt->user_message_body)>0)
                <div style="padding: 2%; background: #efefef; margin-bottom: 20px;">
                    <div class="pull-right"> <i> <small>
                                <b>Email From</b>  : {{isset($p_hd->user_email)?$p_hd->user_email:''  }}
                            </small> </i>
                    </div>
                    <p> &nbsp; </p>
                    <div style="line-height: 30px;"> <b> Message Body :</b>
                        <div style="padding-left: 10%;"> <?php echo $dt->user_message_body; ?>
                        </div>
                    </div>
                </div>
                @endif
                @if(count($dt->custom_message)>0)
                    <div style="padding: 2%; background: #efefef; margin-bottom: 20px;">
                        <div class="pull-right"> <i> <small>
                                    <b>To Email</b>  : {{isset($p_hd->user_email)?$p_hd->user_email:''  }}
                                </small> </i>
                        </div>
                        <p> &nbsp; </p>
                        <div style="line-height: 30px;"> <b> Custom Message  :</b>
                            <div style="padding-left: 10%;"> {{$dt->custom_message}}
                            </div>
                        </div>
                        <P>&nbsp;</P>
                        <i> <small> Sent Time :  {{ isset($dt->sent_time)?$dt->sent_time:'' }} </small></i>
                        <div class="pull-right"> <i> <small>
                                    <b>Sender Email</b> : {{ isset($p_hd->relSenderEmail->email)?$p_hd->relSenderEmail->email:'' }}
                                </small> </i>
                        </div>
                        <p> &nbsp; </p>
                    </div>
                @endif
                {{--<div> <i><small><b>Sender Email : {{ isset($p_hd->sender_email)?$p_hd->sender_email:'' }} </b> </small></i> </div>--}}
        @endforeach
        </div>
    </div>

    <div class="row" style="padding: 20px;">

        @if($check_settings_is_paused)
           @if($check_settings_is_paused->status == 'yes' )
{{--           @if($check_settings_is_paused->status == 'yes' && $check_settings_public_domain->status =='public' && $p_hd->message_order =='1')--}}
                {!! Form::open(['route' => 'send_custom_msg', 'method'=>'POST', 'files'=>true]) !!}
                <div class="form-group">
                    <b>{!! Form::label('custom_message', 'Compose your Text:', ['class' => 'control-label']) !!}</b>
                    {!! Form::textarea('custom_message', Input::old('custom_message'), ['class' => 'form-control','required']) !!}
                    {!! Form::file('files[]', array('multiple'=>true)) !!}
                    {!! Form::hidden('popped_message_header_id', $p_hd->id) !!}
                    {!! Form::hidden('sent_time', date('Y-m-d H:i:s', time())) !!}
                    {!! Form::hidden('user_email', $p_hd->user_email) !!}
                    {!! Form::hidden('campaign_id', $p_hd->campaign_id) !!}
                </div>
                {!! Form::submit('Send', ['class' => 'btn btn-success pull-right']) !!}
                {!! Form::close() !!}

            <p> &nbsp; </p>
           @endif
        @endif

    </div>


</div>

<div class="modal-footer">
    <a href="{{ URL::previous() }}" class="btn btn-default" type="button"> Close </a>
</div>

    </div>
</div>