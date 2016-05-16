
<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
    {!! Form::text('name', null, ['id'=>'f-name', 'class' => 'form-control', 'required'=>'required']) !!}
</div>

<p> &nbsp; </p>

<div class="panel-body">
    {!! Form::open(['route' => 'crud.store']) !!}
    <form role="form" class="form-horizontal tasi-form">
        <div class="form-group has-success">
            {!! Form::label('first_name', 'First Name:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('first_name', null, ['id'=>'f-name', 'class' => 'form-control']) !!}
                <p class="help-block">Successfully done</p>
            </div>
        </div>
        <div class="form-group has-error">
            {!! Form::label('first_name', 'Last Name:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('last_name', null, ['id'=>'l-name', 'class' => 'form-control']) !!}
                <p class="help-block">Aha you gave a wrong info</p>
            </div>
        </div>
        <div class="form-group has-warning">
            {!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['id'=>'email2', 'class' => 'form-control']) !!}
                <p class="help-block">Something went wrong</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button class="btn btn-danger" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>


<a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}