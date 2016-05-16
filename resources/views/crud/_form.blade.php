
<div class="form-group">
    {!! Form::label('name', 'name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<p> &nbsp; </p>


<a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Save changes', ['class' => 'btn btn-success']) !!}