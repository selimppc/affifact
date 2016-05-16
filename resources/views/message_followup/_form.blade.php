@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

{!!  Form::hidden('campaign_id', $campaign_id)!!}

<div class="form-group">
    {!! Form::label('html', 'Html:', ['class' => 'control-label']) !!}
    {!! Form::Select('html',array('true'=>'True','false'=>'False'),Input::old('html'),['class'=>'form-control ','required'=>'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('delay', 'Delay:', ['class' => 'control-label']) !!}
    <small class="required">(in minutes)</small>
    {!! Form::number('delay', Input::old('delay'), ['class' => 'form-control']) !!}
</div>
{{--@if(isset($order))
<div class="form-group">
    {!! Form::label('order', 'Order:', ['class' => 'control-label']) !!}
    {!! Form::number('order', $order, ['class' => 'form-control']) !!}
</div>
    @else
    <div class="form-group">
        {!! Form::label('order', 'Order:', ['class' => 'control-label']) !!}
        {!! Form::number('order', Input::old('order'), ['class' => 'form-control']) !!}
    </div>

@endif--}}
{{--<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', Input::old('description'),['size' => '30x5', 'class'=>'form-control']) !!}
</div>--}}
{{--
<h4>Attachments :</h4>
<div class="form-group">
@if(isset($followup_attachment))
    @foreach($followup_attachment as $attachments)
            @if($attachments->file_type == 'image')
<br>
                <div class="row">
                    <div id="{{ $attachments->id  }}">
                    <a href="{{ route('message-followup.image.show', $attachments->id) }}"  data-toggle="modal" data-target="#imageView"><img src="{{ URL::to($attachments->file_name) }}" height="60px" width="60px" alt="{{$attachments->file_name}}" />
                    </a>
                    <span style="cursor:pointer" class="btn-danger" onclick="deleteFile(this.id)" id="{{  $attachments->id }}" ><i class="icon-trash"></i>Delete </span>
                        </div>
                </div>

            @else
                <div class="row">
                    <div id="{{ $attachments->id  }}">
                    <a href="{{ URL::to($attachments->file_name) }}" onclick="return confirm('Are you sure to Download?')" download>
                        <img src="{{ URL::to('default-images/file.png') }}" height="60px" width="60px" alt="{{$attachments->file_name}}" />
                        {{$attachments->file_name}}
                    </a>
                    <span style="cursor:pointer" class="btn-danger" onclick="deleteFile(this.id)" id="{{  $attachments->id }}" ><i class="icon-trash"></i>Delete</span>
                        </div>
                </div>
            @endif

    @endforeach
@endif
    </div>
<p> &nbsp; </p>
<div class="form-group">
    {!! Form::label('file_name', 'File Name:', ['class' => 'control-label']) !!}
    {!! Form::file('file_name[]',array('multiple'=>true)) !!}
</div>--}}

<a href="" class="btn btn-default" type="button"> Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}