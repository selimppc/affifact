@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-group">
    {!! Form::label('token', 'Token:', ['class' => 'control-label']) !!}
    {!! Form::text('token', null, ['id'=>'token', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['onkeyup'=>"javascript:this.value=this.value.replace(/[<,>]/g,'');", 'size' => '30x5', 'id'=>'ccomment', 'class' => 'form-control', 'minlength'=>'2']) !!}



</div>

<p> &nbsp; </p>

<a href="{{ URL::route('token.index') }}"  class="btn btn-default" type="button"> Close </a>

{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}