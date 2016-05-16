<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AffiFact | Modal on Page Load</title>

    {{--<link href="{{ URL::asset('etsb/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >--}}

    <link href="{{ URL::asset('etsb/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >

    <!--external css-->
    <link href="{{ URL::asset('etsb/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" >

    <!-- Data Tables -->
    <link href="{{ URL::asset('etsb/assets/advanced-datatable/media/css/demo_page.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/advanced-datatable/media/css/demo_table.css') }}" rel="stylesheet" type="text/css" >

    <!-- Custom styles for this ui_elements -->
    <link href="{{ URL::asset('etsb/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/css/style-responsive.css') }}" rel="stylesheet" type="text/css" >

    {{--<script type="text/javascript" src="{{ URL::asset('etsb/assets/jquery/jquery-2.1.4.min.js') }}"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>--}}

    <!-- Advanced Feature -->
    <link href="{{ URL::asset('etsb/assets/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-timepicker/compiled/timepicker.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/bootstrap-datetimepicker/css/datetimepicker.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('etsb/assets/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" >


</head>
<body>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Subscribe our Newsletter</h4>
            </div>
            <div class="modal-body">
                <p>Welcome to modal </p>
                <p> Thank you</p>
            </div>
        </div>
    </div>
</div>


{{--<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/bootstrap.min.js') }}"></script>--}}



<!-- js placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery.scrollTo.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery.nicescroll.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery.sparkline.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/jquery.customSelect.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/respond.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ URL::asset('etsb/js/jquery.dcjqaccordion.2.7.js') }}"></script>

<!--common script for all pages-->
<script type="text/javascript" src="{{ URL::asset('etsb/js/common-scripts.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/sparkline-chart.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/easy-pie-chart.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/count.js') }}"></script>

<!--Data Tables script for all pages-->
{{--<script type="text/javascript" src="{{ URL::asset('etsb/assets/advanced-datatable/media/js/jquery.js') }}"></script>--}}
<script type="text/javascript" src="{{ URL::asset('etsb/assets/advanced-datatable/media/js/jquery.dataTables.js') }}"></script>


<!--Validation script for all pages-->
<script type="text/javascript" src="{{ URL::asset('etsb/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/js/form-validation-script.js') }}"></script>

<!--Advanced Feature plugins-->
<script type="text/javascript" src="{{ URL::asset('etsb/assets/fuelux/js/spinner.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('etsb/assets/jquery-multi-select/js/jquery.quicksearch.js') }}"></script>

<!--Advanced Form plugins-->
{{--<script type="text/javascript" src="{{ URL::asset('etsb/js/advanced-form-components.js') }}"></script>--}}


<script type="text/javascript">
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>

</body>
</html>                                		
