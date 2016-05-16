@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
        <!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Inline form
            </header>
            <div class="panel-body">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>

            </div>
        </section>

    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Basic Forms
            </header>
            <div class="panel-body">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile">
                        <p class="help-block">Example block-level help text here.</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Check me out
                        </label>
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>

            </div>
        </section>
    </div>
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Horizontal Forms
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="inputEmail1" placeholder="Email">
                            <p class="help-block">Example block-level help text here.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="inputPassword1" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">

            <div class="panel-body">
                <a href="#myModal" data-toggle="modal" class="btn btn-xs btn-success">
                    Form in Modal
                </a>
                <a href="#myModal-1" data-toggle="modal" class="btn btn-xs btn-warning">
                    Form in Modal 2
                </a>
                <a href="#myModal-2" data-toggle="modal" class="btn btn-xs btn-danger">
                    Form in Modal 3
                </a>

                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Form Tittle</h4>
                            </div>
                            <div class="modal-body">

                                <form role="form">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <input type="file" id="exampleInputFile3">
                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Check me out
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Form Tittle</h4>
                            </div>
                            <div class="modal-body">

                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                        <div class="col-lg-10">
                                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-default">Sign in</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-2" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Form Tittle</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-inline" role="form">
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                        <input type="email" class="form-control sm-input" id="exampleInputEmail5" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                        <input type="password" class="form-control sm-input" id="exampleInputPassword5" placeholder="Password">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Remember me
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-default">Sign in</button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Form Elements
            </header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Default</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Help text</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                            <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Rounder</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control round-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Input focus</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="focusedInput" type="text" value="This is focused...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Disabled</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Placeholder</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" placeholder="placeholder">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password"  class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Static control</label>
                        <div class="col-lg-10">
                            <p class="form-control-static">email@example.com</p>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group has-success">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Input with success</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputSuccess">
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="col-sm-2 control-label col-lg-2" for="inputWarning">Input with warning</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputWarning">
                        </div>
                    </div>
                    <div class="form-group has-error">
                        <label class="col-sm-2 control-label col-lg-2" for="inputError">Input with error</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputError">
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Control sizing</label>
                        <div class="col-lg-10">
                            <input class="form-control input-lg m-bot15" type="text" placeholder=".input-lg">
                            <input class="form-control m-bot15" type="text" placeholder="Default input">
                            <input class="form-control input-sm m-bot15" type="text" placeholder=".input-sm">

                            <select class="form-control input-lg m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                            <select class="form-control m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                            <select class="form-control input-sm m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Checkboxes and radios</label>
                        <div class="col-lg-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one is this and that&mdash;be sure to include why it's great
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one is this and that&mdash;be sure to include why it's great option one
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                    Option one is this and that&mdash;be sure to include why it's great
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    Option two can be something else and selecting it will deselect option one
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Inline checkboxes</label>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox2" value="option2"> 2
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox3" value="option3"> 3
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Selects</label>
                        <div class="col-lg-10">
                            <select class="form-control m-bot15">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>

                            <select multiple class="form-control">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Column sizing</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder=".col-lg-2">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder=".col-lg-3">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder=".col-lg-4">
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                Input groups
            </header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" >Basic examples</label>
                        <div class="col-lg-10">
                            <div class="input-group m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">.00</span>
                            </div>

                            <div class="input-group m-bot15">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" >Sizing</label>
                        <div class="col-lg-10">
                            <div class="input-group input-group-lg m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control input-lg" placeholder="Username">
                            </div>

                            <div class="input-group m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                            <div class="input-group input-group-sm m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" >Checkboxe and radio</label>
                        <div class="col-lg-10">
                            <div class="input-group m-bot15">
                                              <span class="input-group-addon">
                                                <input type="checkbox">
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                              <span class="input-group-addon">
                                                <input type="radio">
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" >Button addons</label>
                        <div class="col-lg-10">
                            <div class="input-group m-bot15">
                                              <span class="input-group-btn">
                                                <button class="btn btn-white" type="button">Go!</button>
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                              <span class="input-group-btn">
                                                <button class="btn btn-white" type="button">Go!</button>
                                              </span>
                            </div>

                            <div class="input-group m-bot15">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label col-lg-2" >Segmented buttons</label>
                        <div class="col-lg-10">
                            <div class="input-group m-bot15">
                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-white" type="button">Action</button>
                                    <button tabindex="-1" data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-white" type="button">Action</button>
                                    <button tabindex="-1" data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        Switch
                    </header>
                    <div class="panel-body">
                        <div class="row m-bot15">
                            <div class="col-sm-6 text-center">
                                <input type="checkbox" checked="" data-toggle="switch" />
                            </div>
                            <div class="col-sm-6 text-center">
                                <input type="checkbox" data-toggle="switch" />
                            </div>
                        </div>
                        <div class="row m-bot15">
                            <div class="col-sm-6 text-center">
                                <div class="switch switch-square"
                                     data-on-label="<i class=' icon-ok'></i>"
                                     data-off-label="<i class='icon-remove'></i>">
                                    <input type="checkbox" />
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">
                                <div class="switch switch-square"
                                     data-on-label="<i class=' icon-ok'></i>"
                                     data-off-label="<i class='icon-remove'></i>">
                                    <input type="checkbox" checked="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <input type="checkbox" disabled data-toggle="switch" />
                            </div>
                            <div class="col-sm-6 text-center">
                                <input type="checkbox" checked disabled data-toggle="switch" />
                            </div>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        Tags Input
                    </header>
                    <div class="panel-body">
                        <input name="tagsinput" id="tagsinput" class="tagsinput" value="Flat,Design,Lab,Clean" />
                    </div>
                </section>
            </div>
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        Custom Checkbox & Radio
                    </header>
                    <div class="panel-body">
                        <form action="#" method="get" accept-charset="utf-8">
                            <div class="checkboxes">
                                <label class="label_check" for="checkbox-01">
                                    <input name="sample-checkbox-01" id="checkbox-01" value="1" type="checkbox" checked /> I agree to the terms &#38; conditions.
                                </label>
                                <label class="label_check" for="checkbox-02">
                                    <input name="sample-checkbox-02" id="checkbox-02" value="1" type="checkbox" /> Please send me regular updates. </label>
                                <label class="label_check" for="checkbox-03">
                                    <input name="sample-checkbox-02" id="checkbox-03" value="1" type="checkbox" /> This is nice checkbox.</label>

                            </div>
                            <div class="radios">
                                <label class="label_radio" for="radio-01">
                                    <input name="sample-radio" id="radio-01" value="1" type="radio" checked /> This is option A...
                                </label>
                                <label class="label_radio" for="radio-02">
                                    <input name="sample-radio" id="radio-02" value="1" type="radio" /> and this is option B...
                                </label>
                                <label class="label_radio" for="radio-03">
                                    <input name="sample-radio" id="radio-03" value="1" type="radio" /> or simply choose option C
                                </label>
                            </div>
                        </form>
                    </div>

                </section>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Masked inputs
                    </header>
                    <div class="panel-body">
                        <form action="#" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">ISBN 1</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="999-99-999-9999-9" class="form-control">
                                    <span class="help-inline">999-99-999-9999-9</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">ISBN 2</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="999 99 999 9999 9" class="form-control">
                                    <span class="help-inline">999 99 999 9999 9</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">ISBN 3</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="999/99/999/9999/9" class="form-control">
                                    <span class="help-inline">999/99/999/9999/9</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">IPV4</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="999.999.999.9999" class="form-control">
                                    <span class="help-inline">192.168.110.310</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">IPV6</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="9999:9999:9999:9:999:9999:9999:9999" class="form-control">
                                    <span class="help-inline">4deg:1340:6547:2:540:h8je:ve73:98pd</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tax ID</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="99-9999999" class="form-control">
                                    <span class="help-inline">99-9999999</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="(999) 999-9999" class="form-control">
                                    <span class="help-inline">(999) 999-9999</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Currency</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="$ 999,999,999.99" class="form-control">
                                    <span class="help-inline">$ 999,999,999.99</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="99/99/9999" class="form-control">
                                    <span class="help-inline">dd/mm/yyyy</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date 2</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" data-mask="99-99-9999" class="form-control">
                                    <span class="help-inline">dd-mm-yyyy</span>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        CKEditor
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <form action="#" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-sm-2">CKEditor</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ckeditor" name="editor1" rows="6"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
</div>
<!-- page end-->
@stop