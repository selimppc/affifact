<div class="form-group">
    @if(isset($campaign_details))
    {!! Form::label('campaign_id', 'Campaign Name:', ['class' => 'control-label']) !!}
    {!! Form::text('campaign_name', $campaign_details->name , ['class' => 'form-control','readonly']) !!}
    {!! Form::hidden('campaign_id', $campaign_details->id ) !!}
    @else
        {!! Form::hidden('campaign_id', $campaign_id ) !!}
    @endif
</div>

<div class="form-group">
    {!! Form::label('html', 'Html:', ['class' => 'control-label']) !!}
    {!! Form::select('html', array('true'=>'True','false'=>'false'),Input::old('campaign_id'),['class' => 'form-control','required'=>'true']) !!}
</div>

    <div class="form-group">
    {!! Form::label('delay', 'Delay:', ['class' => 'control-label']) !!}
        <small class="required">(in minutes)</small>
    {!! Form::number('delay', Input::old('delay'), ['class' => 'form-control','id'=>'delay','required'=>'true']) !!}
    <p id="delay-error"></p>

    <!-- Add order later for reorder messages{!! Form::hidden('order', '' ) !!}-->
</div>

<p> &nbsp; </p>

<a href="" class="btn btn-default" type="button" > Close </a>
{!! Form::submit('Submit', ['class' => 'btn btn-success','id' => 'message_submit']) !!}