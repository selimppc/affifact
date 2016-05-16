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
                jQuery UI Sliders
            </header>
            <div class="panel-body">
                <table class="table sliders">
                    <tbody>
                    <tr>
                        <td style="width:14%">Default</td>
                        <td>
                            <div id="default-slider" class="slider"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Snap to Increments</td>
                        <td>
                            <div id="snap-inc-slider" class="slider"></div>
                            <div class="slider-info">
                                Amount ($50 increments):
                                <span id="snap-inc-slider-amount"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Range</td>
                        <td>
                            <div id="slider-range" class="slider"></div>
                            <div class="slider-info">
                                Price range:
                                <span id="slider-range-amount"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Maximum</td>
                        <td>
                            <div id="slider-range-max" class="slider"></div>
                            <div class="slider-info">
                                Maximum Value:
                                <span id="slider-range-max-amount"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Minimum</td>
                        <td>
                            <div id="slider-range-min" class="slider"></div>
                            <div class="slider-info">
                                Minimum Value:
                                <span class="slider-info" id="slider-range-min-amount"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Graphic EQ</td>
                        <td>
                            <div id="eq">
                                <span>88</span>
                                <span>77</span>
                                <span>55</span>
                                <span>33</span>
                                <span>40</span>
                                <span>45</span>
                                <span>70</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Bound to Select</td>
                        <td>
                            <select name="minbeds" id="minbeds" class="form-control bound-s">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Vertical</td>
                        <td>
                            <div class="slider-vertical-value">
                                Value:
                                <span  class="slider-info" id="slider-vertical-amount"></span>
                            </div>
                            <div id="slider-vertical" class="slider bg-green" style="height: 250px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Range(Vertical)</td>
                        <td>
                            <div class="slider-vertical-value">
                                Target(Millions):
                                <span  class="slider-info" id="slider-range-vertical-amount"></span>
                            </div>
                            <div id="slider-range-vertical" class="slider bg-grey" style="height: 250px;"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<!-- page end-->
@stop
