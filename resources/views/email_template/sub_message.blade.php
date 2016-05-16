{{--
@if(isset($custom_message))
    <h1>
        {{$custom_message}}
    </h1>
@endif--}}


<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">

    <div>
        @if(isset($custom_message))
              {{$custom_message}}
        @endif
    </div>

</div>
</body>
</html>
