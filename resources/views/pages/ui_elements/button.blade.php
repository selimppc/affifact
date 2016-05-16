@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Default Buttons
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-default">Default</button>
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-success">Success</button>
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-warning">Warning</button>
                    <button type="button" class="btn btn-danger">Danger</button>
                </div>
            </section>
        </div>
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Drop Shadow Buttons
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-shadow btn-default">Default</button>
                    <button type="button" class="btn btn-shadow btn-primary">Primary</button>
                    <button type="button" class="btn btn-shadow btn-success">Success</button>
                    <button type="button" class="btn btn-shadow btn-info">Info</button>
                    <button type="button" class="btn btn-shadow btn-warning">Warning</button>
                    <button type="button" class="btn btn-shadow btn-danger">Danger</button>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Rounded Buttons
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-round btn-default">Default</button>
                    <button type="button" class="btn btn-round btn-primary">Primary</button>
                    <button type="button" class="btn btn-round btn-success">Success</button>
                    <button type="button" class="btn btn-round btn-info">Info</button>
                    <button type="button" class="btn btn-round btn-warning">Warning</button>
                    <button type="button" class="btn btn-round btn-danger">Danger</button>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Dropdowns Button
                </header>
                <div class="panel-body">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">Default <span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button">Primary <span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button">Success <span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Split Dropdowns Button
                </header>
                <div class="panel-body">
                    <div class="btn-group">
                        <button class="btn btn-white" type="button">Default</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                    <div class="btn-group dropup">
                        <button class="btn btn-white" type="button">Dropup</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Justified Button groups
                </header>
                <div class="panel-body">
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-success" href="#">Left</a>
                        <a class="btn btn-info" href="#">Middle</a>
                        <a class="btn btn-danger" href="#">Right</a>
                    </div>
                </div>
            </section>

            <section class="panel">
                <header class="panel-heading">
                    Block level button
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-success btn-lg btn-block">Block level button</button>
                    <button type="button" class="btn btn-warning btn-block">Block level button</button>
                    <button type="button" class="btn btn-danger btn-xs btn-block">Block level button</button>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Star Rating Example
                </header>
                <div class="panel-body">
                              <span class="rating">
                                  <span class="star"></span>
                                  <span class="star"></span>
                                  <span class="star"></span>
                                  <span class="star"></span>
                                  <span class="star"></span>
                              </span>
                </div>
            </section>
        </div>
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Buttons Size
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-default btn-lg">Large Button</button>
                    <button type="button" class="btn btn-primary">Default Button</button>
                    <button type="button" class="btn btn-success btn-sm">Small Button</button>
                    <button type="button" class="btn btn-info btn-xs">Extra Small Button</button>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Buttons With Icon
                </header>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary"><i class="icon-cloud"></i> Cloud</button>
                    <button type="button" class="btn btn-success"><i class="icon-eye-open"></i> View </button>
                    <button type="button" class="btn btn-info "><i class="icon-refresh"></i> Update</button>
                    <button type="button" class="btn btn-default "><i class="icon-cloud-upload"></i> Upload</button>
                    <button data-toggle="button" class="btn btn-white">
                        <i class="icon-thumbs-up text-info"></i>
                        55
                    </button>
                    <button data-toggle="button" class="btn btn-white">
                        <i class="icon-home"></i>
                    </button>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Group Buttons
                </header>
                <div class="panel-body">
                    <div class="btn-row">
                        <div class="btn-group">
                            <button class="btn btn-white" type="button">Left</button>
                            <button class="btn btn-white" type="button">Middle</button>
                            <button class="btn btn-white" type="button">Right</button>
                        </div>
                        <div class="btn-group  btn-group-sm">
                            <button class="btn btn-white" type="button">Left</button>
                            <button class="btn btn-white" type="button">Middle</button>
                            <button class="btn btn-white" type="button">Right</button>
                        </div>
                    </div>
                    <p class="text-muted">Vertical button groups</p>
                    <div class="btn-row">
                        <div class="btn-group-vertical">
                            <button class="btn btn-white" type="button">Top</button>
                            <button class="btn btn-white" type="button">Middle</button>
                            <button class="btn btn-white" type="button">Bottom</button>
                        </div>
                    </div>
                    <p class="text-muted">Nested button groups</p>
                    <div class="btn-row">
                        <div class="btn-group">
                            <button class="btn btn-default" type="button">1</button>
                            <button class="btn btn-danger" type="button">2</button>
                            <button class="btn btn-default" type="button">3</button>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"> Dropdown <span class="caret"></span> </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Dropdown link 1</a></li>
                                    <li><a href="#">Dropdown link 2</a></li>
                                    <li><a href="#">Dropdown link 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted">Multiple button groups</p>
                    <div class="btn-row">
                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <button class="btn btn-info" type="button">1</button>
                                <button class="btn btn-info active" type="button">2</button>
                                <button class="btn btn-info" type="button">3</button>
                                <button class="btn btn-info" type="button">4</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button">5</button>
                                <button class="btn btn-success" type="button">6</button>
                                <button class="btn btn-success" type="button">7</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-warning" type="button">8</button>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted">Group Checkbox</p>
                    <div class="btn-row">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="checkbox"> Option 1
                            </label>
                            <label class="btn btn-primary">
                                <input type="checkbox"> Option 2
                            </label>
                            <label class="btn btn-primary">
                                <input type="checkbox"> Option 3
                            </label>
                        </div>
                    </div>

                    <p class="text-muted">Group Radio</p>
                    <div class="btn-row">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="options" id="option1"> Option 1
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="options" id="option2"> Option 2
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="options" id="option3"> Option 3
                            </label>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@stop
