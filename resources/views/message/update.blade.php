<div class="modal-dialog">
    <div class="modal-content">
<div class="modal-header">
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    <h4 class="modal-title">Modal Tittle</h4>
</div>
<div class="modal-body">

    {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['message.update', $data->id]]) !!}
    @include('message._form')
    {!! Form::close() !!}

</div>
    </div>
</div>
<!--script for this page only-->
<script>
    function numberRange() {
        var x, text;

        // Get the value of the input field with id="numb"
        x = document.getElementById("delay").value;

        // If x is Not a Number or less than one or greater than 10
        if (x >= 256) {
            text = "<p class='help-block'>The delay may not be greater than 255</p>";
            document.getElementById("message_submit").disabled = true;
        }
        else{
            text = '';
            document.getElementById("message_submit").disabled = false;
        }
        document.getElementById("delay-error").innerHTML = text;
    }
</script>