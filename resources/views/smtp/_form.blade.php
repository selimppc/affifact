@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('flash_message_error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('flash_message_error') }}</p>
    </div>
@endif


   <div class="form-group">
    {!! Form::label('name', 'Smtp Name', ['class' => 'control-label']) !!}
       <small class="required">(Required)</small>
    {!! Form::text('name', Input::old('name'), ['class' => 'form-control','required']) !!}
    </div>

<div class="form-group">
    {!! Form::label('host', 'Host', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    <i>(for private domain ex:'domain.com' | for public domain ex:'smtp.domain.com')</i>
    {!! Form::text('host', null, ['class' => 'form-control', 'placeholder'=>'domain.com','required']) !!}
</div>




@if($data['type'] != null )
    @if ($data['type'] == 'email-create')
    <div id="check-button">
        <div class="form-group">
            {!! Form::label('server_username', 'Server User Name', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small><br>
            {{--<i>(for gmail, ymail user email/username | for domain put server username)</i>--}}
            {!! Form::text('server_username', null, ['class' => 'form-control','required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('server_password', 'Server Password', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small><br>
            {{--<i>(for gmail, ymail, mail put email-password | for domain put server password)</i>--}}
            {!! Form::password('server_password', array('class'=>'form-control','id'=>'password','name'=>'server_password')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('c_port', 'Cpanel Port:', ['class' => 'control-label']) !!}
            {!! Form::number('c_port', 2082, ['class' => 'form-control','required']) !!}
        </div>

    </div>
        @endif

    @else
    <div class="form-group">
        {!! Form::label('check_domain', 'Chose Your Domain Type', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small><br>
        <i>(for gmail, ymail etc select 'public domain' | for personal domain select 'private domain')</i><br>
        <label class="radio-inline"><input type="radio" name="domain" id="public-domain" class="minimal" onclick="check();" value="public" required><b>Public Domain</b></label>
        <label class="radio-inline"><input type="radio" name="domain" id="private-domain" class="minimal" onclick="check();" value="private"><b>Private Domain</b></label>
    </div>

<div id="check-button" style="display:none;">
    <div class="form-group">
        {!! Form::label('server_username', 'Server User Name', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small><br>
        {{--<i>(for gmail, ymail user email/username | for domain put server username)</i>--}}
        {!! Form::text('server_username', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('server_password', 'Server Password', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small><br>
        {{--<i>(for gmail, ymail, mail put email-password | for domain put server password)</i>--}}
        {!! Form::password('server_password', array('class'=>'form-control','id'=>'password','name'=>'server_password')) !!}
    </div>

     <div class="form-group">
        {!! Form::label('c_port', 'Cpanel Port:', ['class' => 'control-label']) !!}
         <i>(cpanel secure authentication port)</i><br>
        {!! Form::number('c_port', 2082, ['class' => 'form-control']) !!}
    </div>

</div>
@endif


<div class="form-group">
    {!! Form::label('smtp', 'SMTP', ['class' => 'control-label']) !!}
    <small class="required">(Required)</small><br>
    {{--<i>(for gmail, ymail user email/username | for domain put server username)</i>--}}
    {!! Form::text('smtp', null, ['class' => 'form-control']) !!}
</div>
    <div class="form-group">
    {!! Form::label('port', 'SMTP Port:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
    {!! Form::number('port',isset($data['port'])?$data['port']:465, ['class' => 'form-control','required']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('auth', 'Auth:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
    {!! Form::Select('auth',array('true'=>'True','false'=>'False'),Input::old('auth'),['class'=>'form-control ','required']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('secure', 'Secure:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
    {!! Form::Select('secure',array('ssl'=>'SSL','tsl'=>'TSL'),Input::old('secure'),['class'=>'form-control ','required']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('mails_per_day_per_email', 'Mails per day:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
    {!! Form::text('mails_per_day_per_email', isset($data['mails_per_day_per_email'])?$data['mails_per_day_per_email']:10,['class' => 'form-control','required']) !!}
   </div>



   <p> &nbsp; </p>

  <a href="{{ URL::route('smtp.index') }}"  class="btn btn-default" type="button"> Close </a>

  {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
