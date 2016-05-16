@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <!--widget start-->
            <aside class="profile-nav alt green-border">
                <section class="panel">
                    <div class="user-heading alt green-bg">
                        <a href="#">
                            <img alt="" src="etsb/img/profile-avatar.jpg">
                        </a>
                        <h1>Jonathan Smith</h1>
                        <p>jsmith@flatlab.com</p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="javascript:;"> <i class="icon-time"></i> Mail Inbox <span class="label label-primary pull-right r-activity">19</span></a></li>
                        <li><a href="javascript:;"> <i class="icon-calendar"></i> Recent Activity <span class="label label-info pull-right r-activity">11</span></a></li>
                        <li><a href="javascript:;"> <i class="icon-bell-alt"></i> Notification <span class="label label-warning pull-right r-activity">03</span></a></li>
                        <li><a href="javascript:;"> <i class="icon-envelope-alt"></i> Message <span class="label label-success pull-right r-activity">10</span></a></li>
                    </ul>

                </section>
            </aside>
            <!--widget end-->
            <!--widget start-->
            <div class="panel">
                <div class="panel-body">
                    <div class="bio-chart">
                        <input class="knob" data-width="101" data-height="101" data-displayPrevious=true  data-thickness=".2" value="63" data-fgColor="#4CC5CD" data-bgColor="#e8e8e8">
                    </div>
                    <div class="bio-desk">
                        <h4 class="terques">ThemeForest CMS </h4>
                        <p>Started : 15 July</p>
                        <p>Deadline : 15 August</p>
                    </div>
                </div>
            </div>
            <!--widget end-->
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6">
                    <!--widget start-->
                    <section class="panel">
                        <div class="twt-feed blue-bg">
                            <h1>Jonathan Smith</h1>
                            <p>jsmith@flatlab.com</p>
                            <a href="#">
                                <img src="etsb/img/profile-avatar.jpg" alt="">
                            </a>
                        </div>
                        <div class="weather-category twt-category">
                            <ul>
                                <li class="active">
                                    <h5>320</h5>
                                    Tweet
                                </li>
                                <li>
                                    <h5>1245</h5>
                                    Following
                                </li>
                                <li>
                                    <h5>24657</h5>
                                    Followers
                                </li>
                            </ul>
                        </div>
                        <div class="twt-write col-sm-12">
                            <textarea class="form-control  t-text-area" rows="2" placeholder="Tweet Here"></textarea>
                        </div>
                        <footer class="twt-footer">
                            <button class="btn btn-space btn-white" data-toggle="button">
                                <i class="icon-map-marker"></i>
                            </button>
                            <button class="btn btn-space btn-white" data-toggle="button">
                                <i class="icon-camera"></i>
                            </button>
                            <button class="btn btn-space btn-info pull-right" type="button">
                                <i class="icon-twitter"></i>
                                Tweet
                            </button>
                        </footer>
                    </section>
                    <!--widget end-->
                </div>
                <div class="col-lg-6">
                    <!--widget start-->
                    <section class="panel">
                        <header class="panel-heading tab-bg-dark-navy-blue">
                            <ul class="nav nav-tabs nav-justified ">
                                <li class="active">
                                    <a href="#popular" data-toggle="tab">
                                        Popular
                                    </a>
                                </li>
                                <li>
                                    <a href="#comments" data-toggle="tab">
                                        Comments
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#recent" data-toggle="tab">
                                        Recents
                                    </a>
                                </li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content tasi-tab">
                                <div class="tab-pane active" id="popular">
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/product1.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a class=" p-head" href="#">Item One Tittle</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/product2.png">
                                        </a>
                                        <div class="media-body">
                                            <a class=" p-head" href="#">Item Two Tittle</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/product3.png">
                                        </a>
                                        <div class="media-body">
                                            <a class=" p-head" href="#">Item Three Tittle</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="tab-pane" id="comments">
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/avatar-mini.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a class="cmt-head" href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                                            <p> <i class="icon-time"></i> 1 hours ago</p>
                                        </div>
                                    </article>
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/avatar-mini2.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a class="cmt-head" href="#">Nulla vel metus scelerisque ante sollicitudin commodo</a>
                                            <p> <i class="icon-time"></i> 23 mins ago</p>
                                        </div>
                                    </article>
                                    <article class="media">
                                        <a class="pull-left thumb p-thumb">
                                            <img src="etsb/img/avatar-mini3.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a class="cmt-head" href="#">Donec lacinia congue felis in faucibus. </a>
                                            <p> <i class="icon-time"></i> 15 mins ago</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="tab-pane " id="recent">
                                    Recent Item goes here
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--widget end-->

                    <!--widget start-->
                    <div class=" state-overview">
                        <section class="panel">
                            <div class="symbol red">
                                <i class="icon-tags"></i>
                            </div>
                            <div class="value">
                                <h1>140</h1>
                                <p>Sales</p>
                            </div>
                        </section>
                    </div>
                    <!--widget end-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <ul class="summary-list">
                                <li>
                                    <a href="javascript:;">
                                        <i class=" icon-shopping-cart text-primary"></i>
                                        1 Purchase
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-envelope text-info"></i>
                                        15 Emails
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class=" icon-picture text-muted"></i>
                                        2 Photo Upload
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-tags text-success"></i>
                                        19 Sales
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-microphone text-danger"></i>
                                        4 Audio
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Timeline
                              <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                                <a class="icon-remove" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body profile-activity">
                    <h5 class="pull-right">12 August 2013</h5>
                    <div class="activity terques">
                                  <span>
                                      <i class="icon-shopping-cart"></i>
                                  </span>
                        <div class="activity-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="arrow"></div>
                                    <i class=" icon-time"></i>
                                    <h4>10:45 AM</h4>
                                    <p>Purchased new equipments for zonal office setup and stationaries.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="activity alt purple">
                                  <span>
                                      <i class="icon-rocket"></i>
                                  </span>
                        <div class="activity-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="arrow-alt"></div>
                                    <i class=" icon-time"></i>
                                    <h4>12:30 AM</h4>
                                    <p>Lorem ipsum dolor sit amet consiquest dio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="activity blue">
                                  <span>
                                      <i class="icon-bullhorn"></i>
                                  </span>
                        <div class="activity-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="arrow"></div>
                                    <i class=" icon-time"></i>
                                    <h4>10:45 AM</h4>
                                    <p>Please note which location you will consider, or both. Reporting to the VP  you will be responsible for managing.. </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity alt green">
                                  <span>
                                      <i class="icon-beer"></i>
                                  </span>
                        <div class="activity-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="arrow-alt"></div>
                                    <i class=" icon-time"></i>
                                    <h4>12:30 AM</h4>
                                    <p>Please note which location you will consider, or both.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Chats
                              <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                                <a class="icon-remove" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body">
                    <div class="timeline-messages">
                        <!-- Comment -->
                        <div class="msg-time-chat">
                            <a href="#" class="message-img"><img class="avatar" src="etsb/img/chat-avatar.jpg" alt=""></a>
                            <div class="message-body msg-in">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"><a href="#">Jhon Doe</a> at 1:55pm, 13th April 2013</p>
                                    <p>Hello, How are you brother?</p>
                                </div>
                            </div>
                        </div>
                        <!-- /comment -->

                        <!-- Comment -->
                        <div class="msg-time-chat">
                            <a href="#" class="message-img"><img class="avatar" src="etsb/img/chat-avatar2.jpg" alt=""></a>
                            <div class="message-body msg-out">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"> <a href="#">Jonathan Smith</a> at 2:01pm, 13th April 2013</p>
                                    <p>I'm Fine, Thank you. What about you? How is going on?</p>
                                </div>
                            </div>
                        </div>
                        <!-- /comment -->

                        <!-- Comment -->
                        <div class="msg-time-chat">
                            <a href="#" class="message-img"><img class="avatar" src="etsb/img/chat-avatar.jpg" alt=""></a>
                            <div class="message-body msg-in">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"><a href="#">Jhon Doe</a> at 2:03pm, 13th April 2013</p>
                                    <p>Yeah I'm fine too. Everything is going fine here.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /comment -->

                        <!-- Comment -->
                        <div class="msg-time-chat">
                            <a href="#" class="message-img"><img class="avatar" src="etsb/img/chat-avatar2.jpg" alt=""></a>
                            <div class="message-body msg-out">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"><a href="#">Jonathan Smith</a> at 2:05pm, 13th April 2013</p>
                                    <p>well good to know that. anyway how much time you need to done your task?</p>
                                </div>
                            </div>
                        </div>
                        <!-- /comment -->
                        <!-- Comment -->
                        <div class="msg-time-chat">
                            <a href="#" class="message-img"><img class="avatar" src="etsb/img/chat-avatar.jpg" alt=""></a>
                            <div class="message-body msg-in">
                                <span class="arrow"></span>
                                <div class="text">
                                    <p class="attribution"><a href="#">Jhon Doe</a> at 1:55pm, 13th April 2013</p>
                                    <p>Hello, How are you brother?</p>
                                </div>
                            </div>
                        </div>
                        <!-- /comment -->
                    </div>
                    <div class="chat-form">
                        <div class="input-cont ">
                            <input type="text" class="form-control col-lg-12" placeholder="Type a message here...">
                        </div>
                        <div class="form-group">
                            <div class="pull-right chat-features">
                                <a href="javascript:;">
                                    <i class="icon-camera"></i>
                                </a>
                                <a href="javascript:;">
                                    <i class="icon-link"></i>
                                </a>
                                <a class="btn btn-danger" href="javascript:;">Send</a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading">
                    Basic items
                </header>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading">
                    Linked items
                </header>
                <div class="list-group">
                    <a class="list-group-item " href="#">
                        Cras justo odio
                    </a>
                    <a class="list-group-item active" href="javascript:;">Dapibus ac facilisis in</a>
                    <a class="list-group-item" href="javascript:;">Morbi leo risus</a>
                    <a class="list-group-item" href="javascript:;">Porta ac consectetur ac</a>
                    <a class="list-group-item" href="javascript:;">Vestibulum at eros</a>
                    <a class="list-group-item" href="javascript:;">Vestibulum at eros</a>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading">
                    Custom content
                </header>
                <div class="list-group">
                    <a class="list-group-item " href="javascript:;">
                        <h4 class="list-group-item-heading">List group item heading</h4>
                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                    </a>
                    <a class="list-group-item active" href="javascript:;">
                        <h4 class="list-group-item-heading">List group item heading</h4>
                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                    </a>
                    <a class="list-group-item" href="javascript:;">
                        <h4 class="list-group-item-heading">List group item heading</h4>
                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                    </a>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading">
                    Collapsible Widget
                              <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                                <a class="icon-remove" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body">
                    Content goes here
                </div>
            </section>
        </div>
    </div>
@stop
