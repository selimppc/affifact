@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}

</div>

    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'required'=>'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
        {!! Form::password('password', array('class'=>'form-control','id'=>'password','name'=>'password')) !!}
    </div>

<div class="form-group">
    {!! Form::label('smtp_id', 'Smtp Name:', ['class' => 'control-label']) !!}
    {!! Form::select('smtp_id', $smtp_id,Input::old('smtp_id'),['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('imap_id', 'Imap Name:', ['class' => 'control-label']) !!}
    {!! Form::select('imap_id', $imap_id,Input::old('imap_id'),['class' => 'form-control','required']) !!}
</div>

<p> &nbsp; </p>

<a href="{{ URL::route('popping_email.index')}}" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}