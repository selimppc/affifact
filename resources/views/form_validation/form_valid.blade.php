@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <div class="row">
        <header class="panel-heading">
            <a class="btn-sm btn-success pull-right" data-toggle="modal" href="#addData">
                Modal
            </a>
        </header>
    </div>
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Basic validations Form and Text
            </header>
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
        </section>
    </div>
</div>







<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Form validations with Required
            </header>
            <div class="panel-body">
                <div class=" form">
                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="get" action="">
                        <div class="form-group ">
                            {!! Form::label('cname', 'Name (required):', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::text('name', null, ['id'=>'cname', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="form-group ">
                            {!! Form::label('cemail', 'E-Mail (required)', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::email('cemail', null, ['id'=>'cname', 'class' => 'form-control', 'required'=>'required']) !!}
                            </div>
                        </div>

                        <div class="form-group ">
                            {!! Form::label('curl', 'URL (optional)', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::url('cemail', null, ['id'=>'curl', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group ">
                            {!! Form::label('ccomment', 'Your Comment (required)', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::textarea('comment', null, ['onkeyup'=>"javascript:this.value=this.value.replace(/[<,>]/g,'');", 'size' => '30x5', 'id'=>'ccomment', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
</div>





<!-- addData -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Data</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'crud.store']) !!}
                    @include('form_validation._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<!-- modal -->

<!-- page end-->



@stop