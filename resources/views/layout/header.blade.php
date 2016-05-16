<div class="sidebar-toggle-box">
    <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
</div>
<!--logo start-->
<a href="{{ URL::route('home-dashboard') }}" class="logo">Affi<span>Fact</span></a>
<small> Time: <?php echo date('Y-m-d H:i:s'); ?> </small>
<!--logo end-->
<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            @if(Session::has('central_settings'))
                <?php $central_settings =Session::get('central_settings'); ?>

                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    Central Settings <i class="icon-sun"></i>
                    <span class="badge bg-success">{{count($central_settings)}}</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <div class="notify-arrow notify-arrow-green"></div>
                    <li>
                        <p class="green">Setting Status</p>
                    </li>
                    @foreach($central_settings as $values)
                    <li>
                        <a href="#">
                            <div class="task-info">
                                <div class="desc">{{preg_replace('~[-_]~',' ',$values->title)}}</div>
                                <div class="percent">{{$values->status}}</div>
                            </div>
                        </a>
                    </li>
                    @endforeach

                    <li class="external">
                        <a href="{{URL::to('central-settings')}}"><b>See All Settings</b></a>
                    </li>
                </ul>
            @endif
        </li>
        <!-- settings end -->
        {{--<!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-envelope-alt"></i>
                <span class="badge bg-important">5</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <div class="notify-arrow notify-arrow-red"></div>
                <li>
                    <p class="red">You have 5 new messages</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="./etsb/img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jonathan Smith</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is an example msg.
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="./etsb/img/avatar-mini2.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jhon Doe</span>
                                    <span class="time">10 mins</span>
                                    </span>
                                    <span class="message">
                                     Hi, Jhon Doe Bhai how are you ?
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="./etsb/img/avatar-mini3.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jason Stathum</span>
                                    <span class="time">3 hrs</span>
                                    </span>
                                    <span class="message">
                                        This is awesome dashboard.
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="./etsb/img/avatar-mini4.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jondi Rose</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is metrolab
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>--}}
        <!-- inbox dropdown end -->
        <!-- notification dropdown start-->
        {{--<li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="icon-bell-alt"></i>
                <span class="badge bg-warning">7</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <div class="notify-arrow notify-arrow-yellow"></div>
                <li>
                    <p class="yellow">You have 7 new notifications</p>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-danger"><i class="icon-bolt"></i></span>
                        Server #3 overloaded.
                        <span class="small italic">34 mins</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-warning"><i class="icon-bell"></i></span>
                        Server #10 not respoding.
                        <span class="small italic">1 Hours</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-danger"><i class="icon-bolt"></i></span>
                        Database overloaded 24%.
                        <span class="small italic">4 hrs</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-success"><i class="icon-plus"></i></span>
                        New user registered.
                        <span class="small italic">Just now</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-info"><i class="icon-bullhorn"></i></span>
                        Application error.
                        <span class="small italic">10 mins</span>
                    </a>
                </li>
                <li>
                    <a href="#">See all notifications</a>
                </li>
            </ul>
        </li>--}}
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
<div class="top-nav ">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder="Search">
        </li>
        <li class="center"><p><b> {!! isset(Auth::user()->first_name) ?Auth::user()->first_name:'' !!} </b></p></li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                {!! Html::image('/etsb/img/avatar2.png', 'title', array()) !!}
                {{--<span class="username">Jhon Doue</span>--}}
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <div class="log-arrow-up"></div>
                {{--<li><a href="#"><i class=" icon-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="icon-cog"></i> Setting</a></li>
                  <li><a href="#"><i class="icon-bell-alt"></i> Notification</a></li>--}}

            @if(isset(Auth::user()->id))
                <li><a href="#"><i ></i></a></li>
                <li><a href="{{ URL::to('user/profile-info') }}"><i class="icon-cog"></i>Profile</a></li>
                <li><a href="#"><i ></i> </a></li>
                <li><a href={{ route('user.logout') }}><i class="icon-key"></i> Log Out</a></li>
                @else
                    <li><a href={{ route('user-login') }}><i class="icon-key"></i> Sign In</a></li>
            @endif
            </ul>
        </li>
        <!-- user login dropdown end -->
    </ul>
    <!--search & user info end-->
</div>

<style>
    .center{
padding-top: 10px;
    }
</style>