<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    <h4 class="modal-title">Message</h4>
</div>
<div class="modal-body">
    <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="example">
            <tr>
                <th>Campaign Name</th>
                <td>{{ isset($data->campaign_id)?$data->relCampaign->name:'' }}</td>
            </tr>
            <tr>
                <th>Html</th>
                <td>{{ isset($data->html)?ucfirst($data->html):'' }}</td>
            </tr>

            <tr>
                <th>Delay</th>
                <td>{{ isset($data->delay)?ucfirst($data->delay):'' }}</td>
            </tr>

            <tr>
                <!--<th>Order</th>
                <td>{{ isset($data->order)?ucfirst($data->order):'' }}</td>-->
            </tr>
        </table>
    </div>

</div>

<div class="modal-footer">
    <a href="{{ URL::previous()  }}" class="btn btn-default" type="button"> Close </a>
</div>

    </div>
</div>