@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

        <!-- page start-->
<section class="panel">
    <header class="panel-heading">
        Basic Croping
    </header>
    <div class="panel-body">
        <h4>An example with a basic event handler.</h4>
        <p>
            Here we've tied
            several form values together with a simple event handler invocation.
            The result is that the form values are updated in real-time as
            the selection is changed using Jcrop's <em>onChange</em> handler.
        </p>
        <img src="etsb/img/gallery/3.jpg" id="demo1" alt="Jcrop Example" class="img-responsive"/>

    </div>
</section>
<section class="panel">
    <header class="panel-heading">
        Form Integration
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <h4>An example with a basic event handler.</h4>
                <p>
                    Here we've tied
                    several form values together with a simple event handler invocation.
                    The result is that the form values are updated in real-time as
                    the selection is changed using Jcrop's <em>onChange</em> handler.
                </p>
                <img src="etsb/img/gallery/1.jpg" id="demo2" alt="Jcrop Example" class="img-responsive"/>
            </div>
            <div class="col-md-5 col-sm-12">
                <h4>Cropped Image Details:</h4>
                <form id="coords" class="coords form-inline" onsubmit="return false;" action="#">
                    <table class="table ">
                        <tr>
                            <td>
                                <label class="control-label">X1</label>
                            </td>
                            <td>
                                <input type="text" id="x1" name="x1" class="form-control btn-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="control-label">Y1</label>
                            </td>
                            <td>
                                <input type="text" id="y1" name="y1" class="form-control btn-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="control-label">X2</label>
                            </td>
                            <td>
                                <input type="text" id="x2" name="x2" class="form-control btn-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="control-label">Y2</label>
                            </td>
                            <td>
                                <input type="text" id="y2" name="y2" class="form-control btn-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="control-label">Width</label>
                            </td>
                            <td>
                                <input type="text" id="w" name="w" class="form-control btn-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="control-label">Height</label>
                            </td>
                            <td>
                                <input type="text" id="h" name="h" class="form-control btn-sm" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="panel">
    <header class="panel-heading">
        Bisual Effect
    </header>
    <div class="panel-body">
        <h4>An example implementing a preview pane.</h4>
        <p>
            Obviously the most visual demo, the preview pane is accomplished
            entirely outside of Jcrop with a simple jQuery-flavored callback.
            This type of interface could be useful for creating a thumbnail
            or avatar. The onChange event handler is used to update the
            view in the preview pane.
        </p>
        <br>
        <div class="row">
            <div class="col-md-6">
                <img src="etsb/img/gallery/2.jpg" id="demo3" alt="Jcrop Example" width="100%" />
            </div>
            <div class="col-md-6">
                <div id="preview-pane">
                    <div class="preview-container">
                        <img src="etsb/img/gallery/2.jpg" class="jcrop-preview" alt="Preview"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- page end-->
@stop