<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Modal Tittle</h4>
</div>
<div class="modal-body">

    {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['crud.update', $data->id]]) !!}
    @include('crud._form')
    {!! Form::close() !!}

</div>
    </div>
</div>