<?php
$path = \Illuminate\Support\Facades\Request::path();
?>
<div id="sidebar">

</div>
<li>
    @if($path == 'home-dashboard' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{ URL::route('home-dashboard') }}">
        <i class="icon-dashboard"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sub-menu">
    @if($path == 'smtp/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
        <a class="{{$class}}" href="{{ URL::to('smtp/index') }}">
            <i class="icon-dashboard"></i>
            <span>Smtp</span>
        </a>
</li>

<li class="sub-menu">
    @if($path == 'imap/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('imap/index')}}">
        <i class="icon-laptop"></i>
        <span>Imap</span>
    </a>
</li>
{{--
<li class="sub-menu">
    <a href={{URL::to('sender-email/index')}}>
        <i class="icon-cogs"></i>
        <span>Sender Email</span>
    </a>
</li>
--}}
<li class="sub-menu">
    @if($path == 'popping-email/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('popping-email/index')}}">
        <i class="icon-envelope"></i>
        <span>Popping Email</span>
    </a>
</li>

<li class="sub-menu">
    @if($path == 'popped-message' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('popped-message')}}">
        <i class="icon-paste"></i>
        <span>Popped Message</span>
    </a>
</li>
<li class="sub-menu">
    @if($path == 'campaign/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('campaign/index')}}">
        <i class="icon-external-link"></i>
        <span>Campaign</span>
    </a>
</li>

<li class="sub-menu">
    @if($path == 'mail-queue' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('mail-queue')}}">
        <i class="icon-jpy"></i>
        <span>Mail Queue </span>
    </a>
</li>

<li class="sub-menu">
    @if($path == 'followup-mail-queue' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('followup-mail-queue')}}">
        <i class="icon-jpy"></i>
        <span>Followup Mail Queue  </span>
    </a>
</li>

<li class="sub-menu">
    @if($path == 'mail_thread' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('mail_thread')}}">
        <i class="icon-comment-alt"></i>
        <span>Mail Thread</span>
    </a>
</li>

<li class="sub-menu">
    @if($path == 'token/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('token/index')}}">
        <i class="icon-key"></i>
        <span>Token</span>
    </a>
</li>
{{-- For bottom sidebar scroll up, use this div --}}
<div id="down-menu-up">
<li class="sub-menu">
    @if($path == 'filter/index' )
        <?php $class = 'active'; ?>
    @else
        <?php $class = ''; ?>
    @endif
    <a class="{{$class}}" href="{{URL::to('filter/index')}}">
        <i class="icon-filter"></i>
        <span>Filter</span>
    </a>
</li>

    <li class="sub-menu">
        @if($path == 'failed-mail/index' )
            <?php $class = 'active'; ?>
        @else
            <?php $class = ''; ?>
        @endif
        <a class="{{$class}}" href="{{URL::to('failed-mail/index')}}">
            <i class="icon-mail-forward"></i>
            <span>Send Mail Failed</span>
        </a>
    </li>

    <li class="sub-menu">
        @if($path == 'settings' )
            <?php $class = 'active'; ?>
        @else
            <?php $class = ''; ?>
        @endif
        <a class="{{$class}}" href="{{URL::to('settings')}}">
            <i class="icon-cog"></i>
            <span>Settings</span>
        </a>
    </li>

    @if(Session::has('user_type'))
        @if(Session::get('user_type')=='admin')
            <li class="sub-menu">
                @if($path == 'user/user-list' )
                    <?php $class = 'active'; ?>
                @else
                    <?php $class = ''; ?>
                @endif
                <a id="user-list" class="{{$class}}" href="{{URL::to('user/user-list')}}">
                    <i class="icon-user-md"></i>
                    <span>User List</span>
                </a>
            </li>
            <li class="sub-menu">
                @if($path == 'user/request' )
                    <?php $class = 'active'; ?>
                @else
                    <?php $class = ''; ?>
                @endif
                <a id="user-request" class="{{$class}}" href="{{URL::to('user/request')}}">
                    <i class="icon-file"></i>
                    <span>Invitation</span>
                </a>
            </li>
            <li class="sub-menu">
                @if($path == 'clean-system' )
                    <?php $class = 'active'; ?>
                @else
                    <?php $class = ''; ?>
                @endif
                <a id="clean-system" class="{{$class}}" href="{{URL::to('clean-system')}}">
                    <i class="icon-trash"></i>
                    <span>Clean System</span>
                </a>
            </li>
        @endif
    @endif
</div>
{{-- For bottom sidebar scroll up, use this div end --}}
<script>
    if ($("#down-menu-up li a").hasClass("active") ) {
        var last_element = $("#down-menu-up li a").last().attr('id');
        $('#sidebar').animate({
            //For bottom sidebar scroll up, use this div
            scrollTop: $("#"+last_element+"").offset().top
        }, 2000);
    }
</script>
{{--
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-tasks"></i>
        <span>Form Stuff</span>
    </a>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-th"></i>
        <span>Data Tables</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('basic-table')}}">Basic Table</a></li>
        <li><a  href="{{URL::to('responsive-table')}}">Responsive Table</a></li>
        <li><a  href="{{URL::to('dynamic-table')}}">Dynamic Table</a></li>
        <li><a  href="{{URL::to('advanced-table')}}">Advanced Table</a></li>
        <li><a  href="{{URL::to('editable-table')}}">Editable Table</a></li>
    </ul>
</li>
<li>
    <a  href="{{URL::to('mail')}}">
        <i class="icon-envelope"></i>
        <span>Mail </span>
        <span class="label label-danger pull-right mail-info">2</span>
    </a>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class=" icon-bar-chart"></i>
        <span>Charts</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('morris')}}">Morris</a></li>
        <li><a  href="{{URL::to('chartjs')}}">Chartjs</a></li>
        <li><a  href="{{URL::to('flot-charts')}}">Flot Charts</a></li>
        <li><a  href="{{URL::to('x-chart')}}">xChart</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-shopping-cart"></i>
        <span>Shop</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('list-view')}}">List View</a></li>
        <li><a  href="{{URL::to('details-view')}}">Details View</a></li>
    </ul>
</li>
<li>
    <a href="{{URL::to('google-map')}}" >
        <i class="icon-map-marker"></i>
        <span>Google Maps </span>
    </a>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-glass"></i>
        <span>Extra</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('blank-page')}}">Blank Page</a></li>
        <li><a  href="{{URL::to('lock-screen')}}">Lock Screen</a></li>
        <li><a  href="{{URL::to('profile')}}">Profile</a></li>
        <li><a  href="{{URL::to('invoice')}}">Invoice</a></li>
        <li><a  href="{{URL::to('search-result')}}">Search Result</a></li>
        <li><a  href="{{URL::to('404-error')}}">404 Error</a></li>
        <li><a  href="{{URL::to('500-error')}}">500 Error</a></li>
    </ul>
</li>
<li>
    <a  href="{{URL::to('login')}}">
        <i class="icon-user"></i>
        <span>Login Page</span>
    </a>
</li>

<!--multi level menu start-->
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-sitemap"></i>
        <span>Multi level Menu</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('menu-item-1')}}">Menu Item 1</a></li>
        <li class="sub-menu">
            <a  href="{{URL::to('menu-item-2')}}">Menu Item 2</a>
            <ul class="sub">
                <li><a  href="javascript:;">Menu Item 2.1</a></li>
                <li class="sub-menu">
                    <a  href="javascript:;">Menu Item 3</a>
                    <ul class="sub">
                        <li><a  href="javascript:;">Menu Item 3.1</a></li>
                        <li><a  href="javascript:;">Menu Item 3.2</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>--}}
<!--multi level menu end-->