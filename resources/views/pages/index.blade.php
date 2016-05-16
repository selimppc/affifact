@extends('layout.master')

@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            <p>{{ Session::get('flash_message') }}</p>
        </div>
    @endif
    @if(Session::has('flash_message_error'))
        <div class="alert alert-danger">
            <p>{{ Session::get('flash_message_error') }}</p>
        </div>
    @endif
    {{--<div class="row">

        <div class="col-lg-12">
            <!--work progress start-->
            <section class="panel">
                <div class="panel-body progress-panel">
                    <div class="task-progress">
                        <h1> Google Authentication </h1>
                        <p> Click the button for getting google data </p>
                    </div>
                    <div class="task-option">
                        <a href="{{ URL::to('auth/google') }}" class="btn btn-danger"> <b>Google Auth </b></a>
                    </div>
                </div>

            </section>
            <!--work progress end-->
        </div>
    </div>--}}


<!--state overview start-->
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-user"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    0
                </h1>
                <p>New Users</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="icon-tags"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    0
                </h1>
                <p>Sales</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="icon-shopping-cart"></i>
            </div>
            <div class="value">
                <h1 class=" count3">
                    0
                </h1>
                <p>New Order</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="icon-bar-chart"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    0
                </h1>
                <p>Total Profit</p>
            </div>
        </section>
    </div>
</div>
<!--state overview end-->


<div class="row">

    <div class="col-lg-12">
        <!--work progress start-->
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Work Progress</h1>
                    <p>Anjelina Joli</p>
                </div>
                <div class="task-option">
                    <select class="styled">
                        <option>Anjelina Joli</option>
                        <option>Tom Crouse</option>
                        <option>Jhon Due</option>
                    </select>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        Target Sell
                    </td>
                    <td>
                        <span class="badge bg-important">75%</span>
                    </td>
                    <td>
                        <div id="work-progress1"></div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        Product Delivery
                    </td>
                    <td>
                        <span class="badge bg-success">43%</span>
                    </td>
                    <td>
                        <div id="work-progress2"></div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        Payment Collection
                    </td>
                    <td>
                        <span class="badge bg-info">67%</span>
                    </td>
                    <td>
                        <div id="work-progress3"></div>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        Work Progress
                    </td>
                    <td>
                        <span class="badge bg-warning">30%</span>
                    </td>
                    <td>
                        <div id="work-progress4"></div>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        Delivery Pending
                    </td>
                    <td>
                        <span class="badge bg-primary">15%</span>
                    </td>
                    <td>
                        <div id="work-progress5"></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--work progress end-->
    </div>
</div>




@stop