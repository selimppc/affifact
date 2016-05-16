<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    <h4 class="modal-title">IMAP View</h4>
</div>
<div class="modal-body">
    <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="example">
            <tr>
                <th class="col-lg-8">Name</th>
                <td>{{ $data->name }}</td>
            </tr>

            <tr>
                <th class="col-lg-8">Host</th>
                <td>{{ $data->host }}</td>
            </tr>

            <tr>
                <th class="col-lg-8">Port</th>
                <td>{{ $data->port }}</td>
            </tr>

            <tr>
                <th class="col-lg-8">Charset</th>
                <td>{{ $data->charset }}</td>
            </tr>

            <tr>
                <th class="col-lg-8">Secure</th>
                <td>{{ $data->secure }}</td>
            </tr>

            <tr>
                <th class="col-lg-8">Mail Sent</th>
                <td>{{ $data->count }}</td>
            </tr>
        </table>
    </div>

</div>

<div class="modal-footer">
    <a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
</div>

    </div>
</div>