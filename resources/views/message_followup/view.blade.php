<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title text-center">View</h4>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-hover table-striped">
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

                {{--<tr>
                    <th>Attachment</th>
                    <td>
                        @if(isset($followup_attachment))
                            @foreach($followup_attachment as $attachments)
                                <div class="" style="float:left;">
                                    @if($attachments->file_type == 'image')

                                        <div>
                                            <a href="{{ route('message-followup.image.show', $attachments->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#imageView"><img src="{{ URL::to($attachments->file_name) }}" height="60px" width="60px" alt="{{$attachments->file_name}}" />
                                            </a>
                                        </div>

                                    @else
                                        <div>
                                            <a href="{{ URL::to($attachments->file_name) }}" onclick="return confirm('Are you sure to Download?')" download>
                                                <img src="{{ URL::to('default-images/file.png') }}" height="60px" width="60px" alt="{{$attachments->file_name}}" />
                                                {{$attachments->file_name}}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>--}}
            </table>
        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()}}" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>
</div>