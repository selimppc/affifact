@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')
        <!--state overview start-->
<div class="row">
    <div class="col-lg-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="icon-home"></i> Home</a></li>
            <li><a href="#">Library</a></li>
            <li class="active">Data</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div id="accordion" class="panel-group m-bot20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">
                            Collapsible Group Item #1
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" id="collapseOne">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">
                            Collapsible Group Item #2
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse" id="collapseTwo">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#collapseThree" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">
                            Collapsible Group Item #3
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse" id="collapseThree">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Heading goes here
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <p>
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </p>
                <p>
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                </p>
            </div>
        </section>

    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Timeline
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
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
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <div class="timeline-messages">
                    <!-- Comment -->
                    <div class="msg-time-chat">
                        <a class="message-img" href="#"><img alt="" src="etsb/img/chat-avatar.jpg" class="avatar"></a>
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
                        <a class="message-img" href="#"><img alt="" src="etsb/img/chat-avatar2.jpg" class="avatar"></a>
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
                        <a class="message-img" href="#"><img alt="" src="etsb/img/chat-avatar.jpg" class="avatar"></a>
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
                        <a class="message-img" href="#"><img alt="" src="etsb/img/chat-avatar2.jpg" class="avatar"></a>
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
                        <a class="message-img" href="#"><img alt="" src="etsb/img/chat-avatar.jpg" class="avatar"></a>
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
                        <input type="text" placeholder="Type a message here..." class="form-control col-lg-12">
                    </div>
                    <div class="form-group">
                        <div class="pull-right chat-features">
                            <a href="javascript:;">
                                <i class="icon-camera"></i>
                            </a>
                            <a href="javascript:;">
                                <i class="icon-link"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-danger">Send</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

@stop
