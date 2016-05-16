@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center" id="nestable_list_menu">
                <button type="button" class="btn btn-success" data-action="expand-all">Expand All</button>
                <button type="button" class="btn btn-warning" data-action="collapse-all">Collapse All</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="border-head">
                <h3>Serialised Output (per list)</h3>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <textarea id="nestable_list_1_output" class=" col-lg-12 form-control"></textarea>
                </div>
                <div class="col-lg-6">
                    <textarea id="nestable_list_2_output" class=" col-lg-12 form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Nestable List 1
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                </header>
                <div class="panel-body">
                    <div class="dd" id="nestable_list_1">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">Item 1</div>
                            </li>
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">Item 2</div>
                                <ol class="dd-list">
                                    <li class="dd-item" data-id="3">
                                        <div class="dd-handle">Item 3</div>
                                    </li>
                                    <li class="dd-item" data-id="4">
                                        <div class="dd-handle">Item 4</div>
                                    </li>
                                    <li class="dd-item" data-id="5">
                                        <div class="dd-handle">Item 5</div>
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="6">
                                                <div class="dd-handle">Item 6</div>
                                            </li>
                                            <li class="dd-item" data-id="7">
                                                <div class="dd-handle">Item 7</div>
                                            </li>
                                            <li class="dd-item" data-id="8">
                                                <div class="dd-handle">Item 8</div>
                                            </li>
                                        </ol>
                                    </li>
                                    <li class="dd-item" data-id="9">
                                        <div class="dd-handle">Item 9</div>
                                    </li>
                                    <li class="dd-item" data-id="10">
                                        <div class="dd-handle">Item 10</div>
                                    </li>
                                </ol>
                            </li>
                            <li class="dd-item" data-id="11">
                                <div class="dd-handle">Item 11</div>
                            </li>
                            <li class="dd-item" data-id="12">
                                <div class="dd-handle">Item 12</div>
                            </li>
                        </ol>
                    </div>
                </div>
            </section>

        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Nestable List 2
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                </header>
                <div class="panel-body">
                    <div class="dd" id="nestable_list_2">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="13">
                                <div class="dd-handle">Item 13</div>
                            </li>
                            <li class="dd-item" data-id="14">
                                <div class="dd-handle">Item 14</div>
                            </li>
                            <li class="dd-item" data-id="15">
                                <div class="dd-handle">Item 15</div>
                                <ol class="dd-list">
                                    <li class="dd-item" data-id="16">
                                        <div class="dd-handle">Item 16</div>
                                    </li>
                                    <li class="dd-item" data-id="17">
                                        <div class="dd-handle">Item 17</div>
                                    </li>
                                    <li class="dd-item" data-id="18">
                                        <div class="dd-handle">Item 18</div>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Nestable List 3
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                </header>
                <div class="panel-body">
                    <div class="dd" id="nestable_list_3">
                        <ol class="dd-list">
                            <li class="dd-item dd3-item" data-id="13">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 13</div>
                            </li>
                            <li class="dd-item dd3-item" data-id="14">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 14</div>
                            </li>
                            <li class="dd-item dd3-item" data-id="15">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 15</div>
                                <ol class="dd-list">
                                    <li class="dd-item dd3-item" data-id="16">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 16</div>
                                    </li>
                                    <li class="dd-item dd3-item" data-id="17">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 17</div>
                                    </li>
                                    <li class="dd-item dd3-item" data-id="18">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 18</div>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </section>

        </div>
    </div>
@stop
