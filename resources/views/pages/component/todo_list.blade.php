@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

        <!--state overview start-->
<!-- page start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel tasks-widget">
            <header class="panel-heading">
                Todo list
            </header>
            <div class="panel-body">

                <div class="task-content">

                    <ul class="task-list">
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Flatlab is Modern Dashboard</span>
                                <span class="badge badge-sm label-success">2 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Fully Responsive & Bootstrap 3.0.2 Compatible</span>
                                <span class="badge badge-sm label-danger">Done</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Daily Standup Meeting</span>
                                <span class="badge badge-sm label-warning">Company</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Write well documentation for this theme</span>
                                <span class="badge badge-sm label-primary">3 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">We have a plan to include more features in future update</span>
                                <span class="badge badge-sm label-info">Tomorrow</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Don't be hesitate to purchase this Dashbord</span>
                                <span class="badge badge-sm label-inverse">Now</span>
                                <div class="pull-right">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Code compile and upload</span>
                                <span class="badge badge-sm label-success">2 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Tell your friends to buy this dashboad</span>
                                <span class="badge badge-sm label-danger">Now</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                                    <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class=" add-task-row">
                    <a class="btn btn-success btn-sm pull-left" href="#">Add New Tasks</a>
                    <a class="btn btn-default btn-sm pull-right" href="#">See All Tasks</a>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel tasks-widget">
            <header class="panel-heading">
                Sortable Todo list
            </header>
            <div class="panel-body">
                <div class="task-content">
                    <ul id="sortable" class="task-list">
                        <li class="list-primary">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp">Flatlab is Modern Dashboard</span>
                                <span class="badge badge-sm label-success">2 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>

                        <li class="list-danger">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Fully Responsive & Bootstrap 3.0.2 Compatible </span>
                                <span class="badge badge-sm label-danger">Done</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-success">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Daily Standup Meeting </span>
                                <span class="badge badge-sm label-warning">Company</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-warning">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Write well documentation for this theme </span>
                                <span class="badge badge-sm label-primary">3 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-info">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> We have a plan to include more features in future update </span>
                                <span class="badge badge-sm label-info">Tomorrow</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-inverse">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Don't be hesitate to purchase this Dashbord </span>
                                <span class="badge badge-sm label-inverse">Now</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-primary">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Code compile and upload </span>
                                <span class="badge badge-sm label-success">2 Days</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>

                        <li class="list-success">
                            <i class=" icon-ellipsis-vertical"></i>
                            <div class="task-checkbox">
                                <input type="checkbox" class="list-child" value=""  />
                            </div>
                            <div class="task-title">
                                <span class="task-title-sp"> Tell your friends to buy this dashboad </span>
                                <span class="badge badge-sm label-danger">Now</span>
                                <div class="pull-right hidden-phone">
                                    <button class="btn btn-success btn-xs icon-ok"></button>
                                    <button class="btn btn-primary btn-xs icon-pencil"></button>
                                    <button class="btn btn-danger btn-xs icon-trash"></button>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class=" add-task-row">
                    <a class="btn btn-success btn-sm pull-left" href="#">Add New Tasks</a>
                    <a class="btn btn-default btn-sm pull-right" href="#">See All Tasks</a>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- page end-->
@stop
