@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('flash_message_error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('flash_message_error') }}</p>
    </div>
@endif

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small>
    {!! Form::text('name', null, ['class' => 'form-control' ,'required']) !!}
    </div>

<div class="form-group">
    {!! Form::label('host', 'Host:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small>
    <i>(ex: imap.example.com)</i>
    {!! Form::text('host', null, ['onkeyup'=>"javascript:this.value=this.value.replace(/[:,'//']/g,'');",'class' => 'form-control','id'=>'host','required']) !!}
    <p id="delay-error"></p>
    </div>

<div class="form-group">
    {!! Form::label('port', 'Port:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small>
    {!! Form::number('port', 993,  ['class' => 'form-control','required']) !!}
    </div>

<div class="form-group">
    {!! Form::label('charset', 'Charset:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small>
    {!! Form::Select('charset',array('utf_8'=>'utf_8','utf_16'=>'utf_16'),Input::old('charset'),['class'=>'form-control','required']) !!}
    </div>

<div class="form-group">
    {!! Form::label('secure', 'Secure:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small>
    {!! Form::Select('secure',array('ssl'=>'SSL','tsl'=>'TSL'),Input::old('secure'),['class'=>'form-control ','required']) !!}
    </div>

{{--
<div class="form-group">
    {!! Form::label('mails_per_day_per_email', 'Mails Per Day:', ['class' => 'control-label']) !!}
    {!! Form::number('mails_per_day_per_email', null,  ['class' => 'form-control','required']) !!}
</div>
--}}

<p> &nbsp; </p>

<div class="form-group">
<a href="" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
  </div>

