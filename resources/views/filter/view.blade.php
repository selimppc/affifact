<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">{{ $data->name }}</h4>
        </div>

        <div class="modal-body">
            <div style="padding: 30px;">
                <table id="" class="table table-bordered table-hover table-striped" style="font-size: medium">
                    <tr>
                        <th class="col-lg-4">Filter</th>
                        <td>{{ $data->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>
</div>