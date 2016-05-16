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
    {!! Form::label('campaign_id', 'Campaign Name:', ['class' => 'control-label']) !!}
@foreach($campaign_details as $details)
        {!! Form::text('campaign_id_name', $details->name, ['id'=>'campaign_id', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required','readonly']) !!}
        {!! Form::hidden('campaign_id',$details->id ) !!}
    @endforeach

</div>

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}
    </div>

@if($data['type'] == 'generated')
<div class="form-group">
    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
<small class="required">Chenge it from server</small><br>
    {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'required'=>'required','readonly']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
    {!! Form::hidden('password',$data['password'] ) !!}
    {!! Form::text('password1', null, ['id'=>'password1', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required','readonly']) !!}
    {{--{!! Form::password('password',  array('class'=>'form-control', isset($data['password']) ? '': 'required','id'=>'password','name'=>'password','readonly')) !!}--}}
</div>
    @else
    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small><br>
        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'required'=>'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small><br>
        <input type="password" value="<?=(isset($data->password) ? $data->password : '')?>" name="password" class='form-control' required>
    </div>
@endif


<div class="form-group">
    {!! Form::label('smtp_id', 'Smtp Name:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    {!! Form::select('smtp_id', $smtp_id, Input::old('smtp_id'),['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('imap_id', 'Imap Name:', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    {!! Form::select('imap_id', $imap_id, Input::old('imap_id'),['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('popping_status', 'Popping Status :', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    {!! Form::Select('popping_status',array('true'=>'True','false'=>'False'),Input::old('popping_status'),['class'=>'form-control ','required']) !!}
</div>


<p> &nbsp; </p>

<a href="{{ route('sender-email.index',$campaign_id_single) }}" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}