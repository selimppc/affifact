<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            <h4 class="modal-title">Sub Message</h4>
        </div>
        <div class="modal-body">
            <div class="adv-table">
                <table  class="display table table-bordered table-striped" id="example">
                    <tr>
                        <th>Description</th>
                        <td class="desc">{!! isset($data->description)?$data->description:'' !!}</td>
                    </tr>

                    <tr>
                        <th>Start Time</th>
                        <td>{{ isset($data->start_time)?$data->start_time:'' }}</td>
                    </tr>

                    <tr>
                        <th>End Time</th>
                        <td>{{ isset($data->end_time)?$data->end_time:'' }}</td>
                    </tr>

                    <tr>
                        <th>Attachment</th>

                        <td>

                            @if(isset($message_data))
                                @foreach($message_data as $attachment)
                                    <div class="" style="float:left;">
                                        @if($attachment->file_type == 'image')

                                            <div>
                                            <a href="{{ route('sub-message.image.show', $attachment->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#imageView"><img src="{{ URL::to($attachment->file_name) }}" height="60px" width="60px" alt="{{$attachment->file_name}}" />
                                                </a>
                                            </div>

                                        @else
                                            <div>
                                            <a href="{{ URL::to($attachment->file_name) }}" onclick="return confirm('Are you sure to Download?')" download>
                                                <img src="{{ URL::to('default-images/file.png') }}" height="60px" width="60px" alt="{{$attachment->file_name}}" />
                                                {{$attachment->file_name}}
                                            </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>


                </table>
            </div>


        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()  }}" id="popped-modal" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>

</div>



