@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-group">
    {!! Form::label('campaign_id', 'Campaign Name:', ['class' => 'control-label']) !!}
@foreach($campaign_details as $details)
        {!! Form::text('campaign_id_name', $details->name, ['id'=>'campaign_id', 'class' => 'form-control', 'minlength'=>'2', 'required'=>'required','readonly']) !!}
        {!! Form::hidden('campaign_id',$details->id ) !!}
    @endforeach

</div>

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
<div class='form-group'>
    <div class="fileupload fileupload-new btn btn-white btn-file fileupload-new fileupload-exists" data-provides="fileupload">
        <i class="icon-paper-clip"></i> Select CSV file</span>
    {!! Form::file('file', Input::old('file'),['class'=>'form-control', 'required']) !!}
        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
    </div>
</div>

<a href="{{ route('sender-email.index',$campaign_id_single) }}" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}