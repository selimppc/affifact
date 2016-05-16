<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    <h4 class="modal-title text-center">View Of : {{ $data->name }}</h4>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Name</th>
            <td>{{ isset($data->name)?$data->name:'' }}</td>
        </tr>
        <tr>
            <th>Popping Email</th>
            <td>{{ isset($data->popping_email_id)?$data->relPoppingEmail->name:'' }}</td>
        </tr>
    </table>
</div>

<div class="modal-footer">
    <a href="{{ URL::previous()}}" class="btn btn-default" type="button"> Close </a>
</div>

    </div>
</div>