@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

        <!-- page start-->

<!--multiple select start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Multiple Select
                          <span class="tools pull-right">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                          </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default</label>
                        <div class="col-md-9">
                            <select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
                                <option>Dallas Cowboys</option>
                                <option>New York Giants</option>
                                <option selected>Philadelphia Eagles</option>
                                <option selected>Washington Redskins</option>
                                <option>Chicago Bears</option>
                                <option>Detroit Lions</option>
                                <option>Green Bay Packers</option>
                                <option>Minnesota Vikings</option>
                                <option selected>Atlanta Falcons</option>
                                <option>Carolina Panthers</option>
                                <option>New Orleans Saints</option>
                                <option>Tampa Bay Buccaneers</option>
                                <option>Arizona Cardinals</option>
                                <option>St. Louis Rams</option>
                                <option>San Francisco 49ers</option>
                                <option>Seattle Seahawks</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Grouped Options</label>
                        <div class="col-md-9">
                            <select multiple="multiple" class="multi-select" id="my_multi_select2" name="my_multi_select2[]">
                                <optgroup label="NFC EAST">
                                    <option>Dallas Cowboys</option>
                                    <option>New York Giants</option>
                                    <option>Philadelphia Eagles</option>
                                    <option>Washington Redskins</option>
                                </optgroup>
                                <optgroup label="NFC NORTH">
                                    <option>Chicago Bears</option>
                                    <option>Detroit Lions</option>
                                    <option>Green Bay Packers</option>
                                    <option>Minnesota Vikings</option>
                                </optgroup>
                                <optgroup label="NFC SOUTH">
                                    <option>Atlanta Falcons</option>
                                    <option>Carolina Panthers</option>
                                    <option>New Orleans Saints</option>
                                    <option>Tampa Bay Buccaneers</option>
                                </optgroup>
                                <optgroup label="NFC WEST">
                                    <option>Arizona Cardinals</option>
                                    <option>St. Louis Rams</option>
                                    <option>San Francisco 49ers</option>
                                    <option>Seattle Seahawks</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="control-label col-md-3">Searchable</label>
                        <div class="col-md-9">
                            <select name="country" class="multi-select" multiple="" id="my_multi_select3" >
                                <option value="AF">Afghanistan</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BA">Bosnia and Herzegowina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, the Democratic Republic of the</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Cote d'Ivoire</option>
                                <option value="HR">Croatia (Hrvatska)</option>
                                <option value="CU">Cuba</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard and Mc Donald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran (Islamic Republic of)</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libyan Arab Jamahiriya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macau</option>
                                <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="AN">Netherlands Antilles</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Reunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint LUCIA</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SK">Slovakia (Slovak Republic)</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SH">St. Helena</option>
                                <option value="PM">St. Pierre and Miquelon</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands (British)</option>
                                <option value="VI">Virgin Islands (U.S.)</option>
                                <option value="WF">Wallis and Futuna Islands</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--multiple select end-->

<!--date picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Date Pickers
                          <span class="tools pull-right">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">

                    <div class="form-group">
                        <label class="control-label col-md-3">Default Datepicker</label>
                        <div class="col-md-3 col-xs-11">
                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" />
                            <span class="help-block">Select date</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Start with years viewMode</label>
                        <div class="col-md-3 col-xs-11">

                            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012"  class="input-append date dpYears">
                                <input type="text" readonly="" value="12-02-2012" size="16" class="form-control">
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                              </span>
                            </div>
                            <span class="help-block">Select date</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Months Only</label>
                        <div class="col-md-3 col-xs-11">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="102/2012"  class="input-append date dpMonths">
                                <input type="text" readonly="" value="02/2012" size="16" class="form-control">
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                              </span>
                            </div>


                            <span class="help-block">Select month only</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date Range</label>
                        <div class="col-md-4">
                            <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control dpd1" name="from">
                                <span class="input-group-addon">To</span>
                                <input type="text" class="form-control dpd2" name="to">
                            </div>
                            <span class="help-block">Select date range</span>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
<!--date picker end-->

<!--datetime picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Datetime Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default input Datetimepicker</label>
                        <div class="col-md-4">
                            <input size="16" type="text" value="2012-06-15 14:45" readonly class="form_datetime form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"> Component Datetimepicker</label>
                        <div class="col-md-4">
                            <div class="input-group date form_datetime-component">
                                <input type="text" class="form-control" readonly="" size="16">
                                                <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger date-set"><i class="icon-calendar"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Advance Datetimepicker</label>
                        <div class="col-md-4">
                            <div data-date="2012-12-21T15:25:00Z" class="input-group date form_datetime-adv">
                                <input type="text" class="form-control" readonly="" size="16">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger date-reset"><i class="icon-remove"></i></button>
                                    <button type="button" class="btn btn-warning date-set"><i class="icon-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Meridian Format</label>
                        <div class="col-md-4">
                            <div data-date="2012-12-21T15:25:00Z" class="input-group date form_datetime-meridian">
                                <input type="text" class="form-control" readonly="" size="16">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger date-reset"><i class="icon-remove"></i></button>
                                    <button type="button" class="btn btn-info date-set"><i class="icon-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </section>
    </div>
</div>
<!--datetime picker end-->

<!--time picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Time Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default Timepicker</label>
                        <div class="col-md-4">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" class="form-control timepicker-default">
                                                <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="icon-time"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">24hr Timepicker</label>
                        <div class="col-md-4">
                            <div class="input-group bootstrap-timepicker">
                                <input type="text" class="form-control timepicker-24">
                                                <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="icon-time"></i></button>
                                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--time picker end-->

<!--color picker start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Color Pickers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal  tasi-form" action="#">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default</label>
                        <div class="col-md-4">
                            <input type="text" class="colorpicker-default form-control" value="#8fff00" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">RGBA</label>
                        <div class="col-md-4">
                            <input type="text" class="colorpicker-rgba form-control" value="rgb(0,194,255,0.78)" data-color-format="rgba" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">As Component</label>
                        <div class="col-md-4 col-xs-11">
                            <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="input-append colorpicker-default color">
                                <input type="text" readonly="" value="" class="form-control">
                                              <span class=" input-group-btn add-on">
                                                  <button class="btn btn-white" type="button" style="padding: 8px">
                                                      <i style="background-color: rgb(124, 66, 84);"></i>
                                                  </button>
                                              </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--color picker end-->

<!--Spinner start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Spinner
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 1</label>
                        <div class="col-md-2">
                            <div id="spinner1">
                                <div class="input-group input-small">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn btn-group-vertical">
                                        <button type="button" class="btn spinner-up btn-xs btn-default">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn spinner-down btn-xs btn-default">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                basic example
                                             </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 2</label>
                        <div class="col-md-2">
                            <div id="spinner2">
                                <div class="input-group input-small">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn btn-group-vertical">
                                        <button type="button" class="btn spinner-up btn-xs btn-danger">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn spinner-down btn-xs btn-danger">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                disabled state
                                             </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Spinner 3</label>
                        <div class="col-md-9">
                            <div id="spinner3">
                                <div class="input-group" style="width:150px;">
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn btn-default spinner-up">
                                            <i class="icon-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-default spinner-down">
                                            <i class="icon-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                 <span class="help-block">
                                 with max value: 10
                                 </span>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-3">Spinner 4</label>
                        <div class="col-md-9">
                            <div id="spinner4">
                                <div class="input-group" style="width:150px;">
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-up btn-warning">
                                            <i class="icon-plus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="spinner-input form-control" maxlength="3" readonly>
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-down btn-danger">
                                            <i class="icon-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                             <span class="help-block">
                                                with step: 5
                                             </span>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--Spinner end-->

<!--Advanced File Input start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Advanced File Input
                                  <span class="tools pull-right">
                                    <a href="javascript:;" class="icon-chevron-down"></a>
                                    <a href="javascript:;" class="icon-remove"></a>
                                </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Default</label>
                        <div class="col-md-4">
                            <input type="file" class="default" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Without input</label>
                        <div class="controls col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Select file</span>
                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                <input type="file" class="default" />
                                                </span>
                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="control-label col-md-3">Image Upload</label>
                        <div class="col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                   <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                   <input type="file" class="default" />
                                                   </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                </div>
                            </div>
                            <span class="label label-danger">NOTE!</span>
                                             <span>
                                             Attached image thumbnail is
                                             supported in Latest Firefox, Chrome, Opera,
                                             Safari and Internet Explorer 10 only
                                             </span>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
<!--Advanced File Input end-->

<!--wysihtml5 start-->
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                WYSIWYG Editors
                              <span class="tools pull-right">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                              </span>
            </header>
            <div class="panel-body">
                <form action="#" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="control-label col-md-3">WYSIHTML5 Editor</label>
                        <div class="col-md-9">
                            <textarea class="wysihtml5 form-control" rows="10"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!--wysihtml5 end-->


<!-- page end-->
@stop