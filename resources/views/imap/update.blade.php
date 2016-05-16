<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    <h4 class="modal-title">IMAP Edit</h4>
</div>
<div class="modal-body">

    <?php  //echo $data->id;  ?>

    {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['imap.update', $data->id]]) !!}
        {!! Form::hidden('id', $data->id) !!}
    @include('imap._form')
    {!! Form::close() !!}

</div>
    </div>
</div>