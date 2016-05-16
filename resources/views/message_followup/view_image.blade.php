<div class="modal-dialog" style="z-index:1050">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Image View</h4>
        </div>
        <div class="modal-body">
            <div class="adv-table">
                @if($image != null)
                    @foreach($image as $value)
                        <img src="{{ URL::to($value->file_name) }} " width="535px" height="400px">
                    @endforeach
                @endif

            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>

    </div>
</div>
