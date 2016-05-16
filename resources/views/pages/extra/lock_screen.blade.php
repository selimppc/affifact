@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')
        <!--state overview start-->
<body class="lock-screen" onload="startTime()">

<div class="lock-wrapper">

    <div id="time"></div>


    <div class="lock-box text-center">
        <img src="etsb/img/follower-avatar.jpg" alt="lock avatar"/>
        <h1>Jonathan Smith</h1>
        <span class="locked">Locked</span>
        <form role="form" class="form-inline" action="index.html">
            <div class="form-group col-lg-12">
                <input type="password" placeholder="Password" id="exampleInputPassword2" class="form-control lock-input">
                <button class="btn btn-lock" type="submit">
                    <i class="icon-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function startTime()
    {
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();
        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        document.getElementById('time').innerHTML=h+":"+m+":"+s;
        t=setTimeout(function(){startTime()},500);
    }

    function checkTime(i)
    {
        if (i<10)
        {
            i="0" + i;
        }
        return i;
    }
</script>
</body>
@stop
