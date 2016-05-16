<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
           {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">Filter name edit</h4>
        </div>
        <div class="modal-body">

            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['filter.update', $data->id]]) !!}
            @include('filter._form')
            {!! Form::close() !!}

        </div>
    </div>
</div>