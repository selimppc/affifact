@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')

    <section>
        <div class="panel panel-primary">
            <!--<div class="panel-heading navyblue"> INVOICE</div>-->
            <div class="panel-body">
                <div class="row invoice-list">
                    <div class="text-center corporate-id">
                        <img src="img/vector-lab.jpg" alt="">
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h4>BILLING ADDRESS</h4>
                        <p>
                            Jonathan Smith <br>
                            44 Dreamland Tower, Suite 566 <br>
                            ABC, Dreamland 1230<br>
                            Tel: +12 (012) 345-67-89
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h4>SHIPPING ADDRESS</h4>
                        <p>
                            Vector Lab<br>
                            Road 1, House 2, Sector 3<br>
                            ABC, Dreamland 1230<br>
                            P: +38 (123) 456-7890<br>
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h4>INVOICE INFO</h4>
                        <ul class="unstyled">
                            <li>Invoice Number		: <strong>69626</strong></li>
                            <li>Invoice Date		: 2013-03-17</li>
                            <li>Due Date			: 2013-03-20</li>
                            <li>Invoice Status		: Paid</li>
                        </ul>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th class="hidden-phone">Description</th>
                        <th class="">Unit Cost</th>
                        <th class="">Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>LCD Monitor</td>
                        <td class="hidden-phone">20 inch Philips LCD Black color monitor</td>
                        <td class="">$ 1000</td>
                        <td class="">2</td>
                        <td>$ 2000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Laptop</td>
                        <td class="hidden-phone">Apple Mac book pro 15” Retina Display. 2.8 GHz Processor,8 GB Ram</td>
                        <td class="">$1750</td>
                        <td class="">1</td>
                        <td>$1750</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Mouse</td>
                        <td class="hidden-phone">Apple Magic Mouse</td>
                        <td class="">$90</td>
                        <td class="">3</td>
                        <td>$270</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Personal Computer</td>
                        <td class="hidden-phone">iMac 21 inch slim body. 1.7 GHz, 8 GB Ram</td>
                        <td class="">$1200</td>
                        <td class="">2</td>
                        <td>$2400</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Printer</td>
                        <td class="hidden-phone">Epson Color Jet printer </td>
                        <td class="">$200</td>
                        <td class="">2</td>
                        <td>$400</td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-4 invoice-block pull-right">
                        <ul class="unstyled amounts">
                            <li><strong>Sub - Total amount :</strong> $6820</li>
                            <li><strong>Discount :</strong> 10%</li>
                            <li><strong>VAT :</strong> -----</li>
                            <li><strong>Grand Total :</strong> $6138</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center invoice-btn">
                    <a class="btn btn-danger btn-lg"><i class="icon-check"></i> Submit Invoice </a>
                    <a class="btn btn-info btn-lg" onclick="javascript:window.print();"><i class="icon-print"></i> Print </a>
                </div>
            </div>
        </div>
    </section>
    <!-- invoice end-->
@stop