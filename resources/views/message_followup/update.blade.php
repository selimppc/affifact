<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($data, ['files'=>true,'method' => 'PATCH', 'route'=> ['message-followup.update', $data->id]]) !!}
            @include('message_followup._form')
            {!! Form::close() !!}
        </div>
    </div>
</div>