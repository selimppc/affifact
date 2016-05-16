<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
           {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">Popping Email Edit</h4>
        </div>
        <div class="modal-body">

            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['popping_email.update', $data->id]]) !!}
            {!! Form::hidden('id', $data->id) !!}
            @include('popping_email._form')
            {!! Form::close() !!}

        </div>
    </div>
</div>