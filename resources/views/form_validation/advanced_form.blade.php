@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

<!--date picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Date Pickers
                          <span class="tools pull-right">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">

                    <div class="form-group">
                        <label class="control-label col-md-3">Default Datepicker</label>
                        <div class="col-md-3 col-xs-11">
                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" />
                            <span class="help-block">Select date</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Start with years viewMode</label>
                        <div class="col-md-3 col-xs-11">

                            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012"  class="input-append date dpYears">
                                <input type="text" readonly="" value="12-02-2012" size="16" class="form-control">
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                              </span>
                            </div>
                            <span class="help-block">Select date</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Months Only</label>
                        <div class="col-md-3 col-xs-11">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="102/2012"  class="input-append date dpMonths">
                                <input type="text" readonly="" value="02/2012" size="16" class="form-control">
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                              </span>
                            </div>


                            <span class="help-block">Select month only</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date Range</label>
                        <div class="col-md-4">
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control dpd1" name="from">
                                <span class="input-group-addon">To</span>
                                <input type="text" class="form-control dpd2" name="to">
                            </div>
                            <span class="help-block">Select date range</span>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
<!--date picker end-->

<!--datetime picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Datetime Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default input Datetimepicker</label>
                        <div class="col-md-4">
                            <input size="16" type="text" value="2012-06-15 14:45" readonly class="form_datetime form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"> Component Datetimepicker</label>
                        <div class="col-md-4">
                            <div class="input-group date form_datetime-component">
                                <input type="text" class="form-control" readonly="" size="16">
                                                <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger date-set"><i class="icon-calendar"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Advance Datetimepicker</label>
                        <div class="col-md-4">
                            <div data-date="2012-12-21T15:25:00Z" class="input-group date form_datetime-adv">
                                <input type="text" class="form-control" readonly="" size="16">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger date-reset"><i class="icon-remove"></i></button>
                                    <button type="button" class="btn btn-warning date-set"><i class="icon-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Meridian Format</label>
                        <div class="col-md-4">
                            <div data-date="2012-12-21T15:25:00Z" class="input-group date form_datetime-meridian">
                                <input type="text" class="form-control" readonly="" size="16">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger date-reset"><i class="icon-remove"></i></button>
                                    <button type="button" class="btn btn-info date-set"><i class="icon-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </section>
    </div>
</div>
<!--datetime picker end-->

<!--time picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Time Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default Timepicker</label>
                        <div class="col-md-4">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" class="form-control timepicker-default">
                                                <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="icon-time"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">24hr Timepicker</label>
                        <div class="col-md-4">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" class="form-control timepicker-24">
                                                <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="icon-time"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--time picker end-->

<!--color picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Color Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default</label>
                        <div class="col-md-4">
                            <input type="text" class="colorpicker-default form-control" value="#8fff00" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">RGBA</label>
                        <div class="col-md-4">
                            <input type="text" class="colorpicker-rgba form-control" value="rgb(0,194,255,0.78)" data-color-format="rgba" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">As Component</label>
                        <div class="col-md-4 col-xs-11">
                            <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="input-append colorpicker-default color">
                                <input type="text" readonly="" value="" class="form-control">
                                              <span class=" input-group-btn add-on">
                                                  <button class="btn btn-white" type="button" style="padding: 8px">
                                                      <i style="background-color: rgb(124, 66, 84);"></i>
                                                  </button>
                                              </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--color picker end-->

<!--Spinner start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Spinner
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 1</label>
                        <div class="col-md-2">
                            <div id="spinner1">
                                <div class="input-group input-small">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn btn-group-vertical">
                                        <button type="button" class="btn spinner-up btn-xs btn-default">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn spinner-down btn-xs btn-default">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                basic example
                                             </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 2</label>
                        <div class="col-md-2">
                            <div id="spinner2">
                                <div class="input-group input-small">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn btn-group-vertical">
                                        <button type="button" class="btn spinner-up btn-xs btn-danger">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn spinner-down btn-xs btn-danger">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                disabled state
                                             </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 3</label>
                        <div class="col-md-9">
                            <div id="spinner3">
                                <div class="input-group" style="width:150px;">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn btn-default spinner-up">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-default spinner-down">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                 <span class="help-block">
                                 with max value: 10
                                 </span>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-3">Spinner 4</label>
                        <div class="col-md-9">
                            <div id="spinner4">
                                <div class="input-group" style="width:150px;">
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-up btn-warning">
                                            <i class="icon-plus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-down btn-danger">
                                            <i class="icon-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                with step: 5
                                             </span>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--Spinner end-->

<!--Advanced File Input start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Advanced File Input
                                  <span class="tools pull-right">
                                    <a href="javascript:;" class="icon-chevron-down"></a>
                                    <a href="javascript:;" class="icon-remove"></a>
                                </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default</label>
                        <div class="col-md-4">
                            <input type="file" class="default" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Without input</label>
                        <div class="controls col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Select file</span>
                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                <input type="file" class="default" />
                                                </span>
                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="control-label col-md-3">Image Upload</label>
                        <div class="col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                   <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                   <input type="file" class="default" />
                                                   </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                </div>
                            </div>
                            <span class="label label-danger">NOTE!</span>
                                             <span>
                                             Attached image thumbnail is
                                             supported in Latest Firefox, Chrome, Opera,
                                             Safari and Internet Explorer 10 only
                                             </span>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
<!--Advanced File Input end-->

<!--wysihtml5 start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                WYSIWYG Editors
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                              </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">WYSIHTML5 Editor</label>
                        <div class="col-md-9">
                            <textarea class="wysihtml5 form-control" rows="10"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--wysihtml5 end-->


@stop