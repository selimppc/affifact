@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')

<!-- page start-->
<div class="row">
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
                Basic Table
            </header>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
                Striped Table
            </header>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading no-border">
                Border Table
            </header>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td rowspan="2">1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@TwBootstrap</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
                Hover Table
            </header>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Sumon</td>
                    <td>Mosa</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Advanced Table
            </header>
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i> Company</th>
                    <th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
                    <th><i class="icon-bookmark"></i> Profit</th>
                    <th><i class=" icon-edit"></i> Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">Vector Ltd</a></td>
                    <td class="hidden-phone">Lorem Ipsum dorolo imit</td>
                    <td>12120.00$ </td>
                    <td><span class="label label-info label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            Adimin co
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>56456.00$ </td>
                    <td><span class="label label-warning label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            boka soka
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>14400.00$ </td>
                    <td><span class="label label-success label-mini">Paid</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            salbal llb
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>2323.50$ </td>
                    <td><span class="label label-danger label-mini">Paid</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td><a href="#">Vector Ltd</a></td>
                    <td class="hidden-phone">Lorem Ipsum dorolo imit</td>
                    <td>12120.00$ </td>
                    <td><span class="label label-primary label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            Adimin co
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>56456.00$ </td>
                    <td><span class="label label-warning label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td><a href="#">Vector Ltd</a></td>
                    <td class="hidden-phone">Lorem Ipsum dorolo imit</td>
                    <td>12120.00$ </td>
                    <td><span class="label label-success label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            Adimin co
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>56456.00$ </td>
                    <td><span class="label label-warning label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td><a href="#">Vector Ltd</a></td>
                    <td class="hidden-phone">Lorem Ipsum dorolo imit</td>
                    <td>12120.00$ </td>
                    <td><span class="label label-info label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#">
                            Adimin co
                        </a>
                    </td>
                    <td class="hidden-phone">Lorem Ipsum dorolo</td>
                    <td>56456.00$ </td>
                    <td><span class="label label-warning label-mini">Due</span></td>
                    <td>
                        <button class="btn btn-success btn-xs"><i class="icon-ok"></i></button>
                        <button class="btn btn-primary btn-xs"><i class="icon-pencil"></i></button>
                        <button class="btn btn-danger btn-xs"><i class="icon-trash "></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
@stop