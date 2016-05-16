@if(Session::has('flash_message_error_generate'))
    <div class="alert alert-danger">
        <p>{{ Session::get('flash_message_error_generate') }}</p>
    </div>
@endif
<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}
</div>
{!! Form::hidden('campaign_id',$campaign_id_single ) !!}


<p> &nbsp; </p>

<a href="" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}