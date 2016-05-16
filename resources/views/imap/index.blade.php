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
                IMAP Management
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <b>Add IMAP</b>
                </a>
            </header>


            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('flash_message') }}</p>
                </div>
            @endif


            <div class="panel-body">
                <div class="adv-table">
                    {{-------------- Filter :Starts -------------------------------------------}}
                    {!! Form::open(['route' => 'imap.index']) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('imap_filter', Input::old('imap_filter'), ['id'=>'imap_filter','placeholder'=>'Search by name','class' => 'form-control','required']) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
            {{--       {!! Form::open(['route' => 'imap.index']) !!}
                    <div  class="col-lg-3 pull-left" >
                        <div class="input-group input-group-sm">
                            {!! Form::text('imap_filter_host', Input::old('imap_filter_host'), ['id'=>'imap_filter_host','placeholder'=>'Search by host','class' => 'form-control','required']) !!}
                            <span class="input-group-btn">
                               <button class="btn btn-info btn-flat" type="submit" >Search</button>
                            </span>
                        </div>
                    </div>

                    {!! Form::close() !!}--}}
                    {{-------------- Filter :Ends -------------------------------------------}}
                    <table  class="display table table-bordered table-striped" id="data-table-example">
                        <thead>
                        <tr>
                            <th> ID </th>
                            <th> Name </th>
                            <th> Host </th>
                            <th> Port </th>
                            <th> Charset </th>
                            <th> Secure </th>
                            {{--<th> Mails Per Day</th>--}}
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $values)
                        <tr class="gradeX">
                            <td>{{$values->id}}</td>
                            <td>{{$values->name}}</td>
                            <td>{{$values->host}}</td>
                            <td>{{$values->port}}</td>
                            <td>{{$values->charset}}</td>
                            <td>{{$values->secure}}</td>
                            <td>
                                <a href="{{ route('imap.show.data', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" title="Imap View"><i class="icon-eye-open"></i></a>
                                <a href="{{ route('imap.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" title="Imap Edit"><i class="icon-edit"></i></a>
                                <a href="{{ route('imap.destroy', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" title="Imap Delete"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->




<!-- addIMAP -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add IMAP</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'imap.store']) !!}
                    @include('imap._form')
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<!-- modal -->



<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<!-- modal -->


<!--script for this page only-->



@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif
@if(Session::has('flash_message_error'))
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
    @endif

        <!--script for this page only-->
    <script>
        function port_host()
        {
            var x, text;
            x = document.getElementById("host").value;

            var fields = x.split(/:/);
            var name = fields[0];
            var street = fields[1];
//alert(street);return;



            // If x is Not a Number or less than one or greater than 10
            if (street !='undefined' ||  street !='') {
                text = "<p class='help-block'>The delay may not be greater than 255</p>";
                document.getElementById("delay-error").innerHTML = text;

                document.getElementById("host").value = "";
            }
        }
    </script>


@stop