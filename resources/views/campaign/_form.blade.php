@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', Input::old('name'), ['id'=>'f-name','class' => 'form-control','required']) !!}
</div>
@if(count($popping_email_id)>0)
<div class="form-group">
    {!! Form::label('popping_email_id', 'Popping Email:', ['class' => 'control-label']) !!}
    {!! Form::select('popping_email_id', $popping_email_id,Input::old('popping_email_id'),['class' => 'form-control','required']) !!}
</div>
@else
    <div class="form-group">
        {!! Form::label('popping_email_id', 'Popping Email:', ['class' => 'control-label']) !!}
        {!! Form::text('popping_email_required', 'No popping email available',['id'=>'f-name','class' => 'form-control','required','disabled']) !!}
    </div>
@endif
<p> &nbsp; </p>

<a href="" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}