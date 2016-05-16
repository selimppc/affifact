<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">SMTP View</h4>
        </div>

        <div class="modal-body">
            <div style="padding: 30px;">
                <table id="" class="table table-bordered table-hover table-striped" style="font-size: medium">
                    <tr>
                        <th class="col-lg-4">Name</th>
                        <td>{{ $data->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">Server User Name</th>
                        <td>{{ $data->server_username }}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-4">Host</th>
                        <td>{{ $data->host }}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-4">Port</th>
                        <td>{{ $data->port }}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-4">Auth</th>
                        <td>{{ $data->auth }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">Secure</th>
                        <td>{{ $data->secure }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">Mail Per Day</th>
                        <td>{{ $data->mails_per_day_per_email }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">Email Sent</th>
                        <td>{{ $data->count }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">Email Type</th>
                        <td>{{ $data->type }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-4">cPanel port</th>
                        <td>{{ $data->c_port }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>
</div>