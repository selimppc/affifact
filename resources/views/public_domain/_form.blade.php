@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required'=>'required']) !!}
</div>

{{--<div class="form-group">
    {!! Form::label('domain_name', 'Domain Name:', ['class' => 'control-label']) !!}
    {!! Form::text('domain_name', null, ['class' => 'form-control', 'required'=>'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
    {!! Form::text('status', null, [ 'class' => 'form-control']) !!}
</div>--}}
<p> &nbsp; </p>

<a href="{{ URL::route('public_domain.index') }}"  class="btn btn-default" type="button"> Close </a>

{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}