@extends('layout.master')
@section('sidebar')
@parent
@include('layout.sidebar')
@stop

@section('content')



        <!--state overview start-->
<div class="row state-overview">

    <div class="col-lg-12 col-sm-12">
        <div class="row center-block"> <h5>24 Hours Summery</h5>  </div>

        <section class="panel">
            <div class="symbol red">
                <i class="icon-tags"></i>
            </div>
            <div class="col-sm-10 pull-right">
                <div class="col-sm-6">
                    <h1 class="">
                        {{$mail_read_total}}
                    </h1>
                    <p>Mails Read</p>
                </div>
                <div class="col-sm-6">
                    <h1 class="">
                        {{$mail_sent_total}}
                    </h1>
                    <p>Mail Sent</p>
                </div>
            </div>
        </section>
    </div>

</div>
<!--state overview end-->


<!--state overview start-->
<div class="row state-overview">

    <div class="col-lg-12 col-sm-12">
        <div class="row center-block"> <h5>Campaign Wise History</h5>  </div>

        <div class="symbol blue">
            <i class="icon-bar-chart"></i>
        </div>
        <div class="col-sm-10 pull-right">
            <section class="panel">
                <table class="display table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Campaign ID</th>
                        <th>Mail Read</th>
                        <th>Mail Sent</th>
                    </tr>

                    </thead>
                    <tbody>
                    @for($i=0; $i < count($campaign_wise_data_mail_read); $i++ )
                        <tr>
                            @if(isset($campaign_wise_data_mail_read[$i]))
                                <td>{{ $campaign_wise_data_mail_read[$i]->campaign_id }}</td>
                                <td>{{ $campaign_wise_data_mail_read[$i]->mail_read }}</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif

                            @if(isset($campaign_wise_data_mail_sent[$i]->mail_sent))
                                <td>{{ $campaign_wise_data_mail_sent[$i]->mail_sent }}</td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endfor
                    </tbody>

                </table>
            </section>
        </div>

    </div>

</div>
<!--state overview end-->



<div class="row center-block"> <h5>Sender Email Wise History</h5>  </div>
<!--state overview start-->
<div class="row state-overview">
    <div class="col-lg-12 col-sm-12">

        <div class="symbol terques">
            <i class="icon-user"></i>
        </div>
        <div class="col-sm-10 pull-right">
            <section class="panel">
                <table class="display table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Campaign ID</th>
                        <th>Sender Email</th>
                        <th>Mail Read</th>
                        <th>Mail Sent</th>
                        <th>Mail Limit</th>
                    </tr>

                    </thead>
                    <tbody>
                    @for($j=0; $j < count($sender_email_wise_camp); $j++ )
                        <tr>
                            <td>{{ $sender_email_wise_camp[$j]->campaign_id }}</td>
                            <td>{{ $sender_email_wise_camp[$j]->sender_email }}</td>
                            @if(count($sender_email_wise_camp_mail_read)>0)
                                @for($k=0; $k < count($sender_email_wise_camp_mail_read); $k++)
                                    @if($sender_email_wise_camp_mail_read[$k]->sender_email == $sender_email_wise_camp[$j]->sender_email)
                                        <td>{{ $sender_email_wise_camp_mail_read[$k]->mail_read }}</td>
                                    @elseif(count($sender_email_wise_camp_mail_read) == count($sender_email_wise_camp))
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                            @else
                                <td></td>
                            @endif
                            @if(count($sender_email_wise_camp_mail_sent)>0)
                                @for($l=0; $l < count($sender_email_wise_camp_mail_sent); $l++)
                                    @if($sender_email_wise_camp_mail_sent[$l]->sender_email == $sender_email_wise_camp[$j]->sender_email)
                                        <td>{{ $sender_email_wise_camp_mail_sent[$l]->mail_sent }}</td>
                                    @elseif(count($sender_email_wise_camp_mail_sent) == count($sender_email_wise_camp))
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                            @else
                                <td></td>
                            @endif
                            <td>{{ $sender_email_wise_camp[$j]->count }}/{{ $sender_email_wise_camp[$j]->mails_per_day_per_email }}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </section>

        </div>

    </div>

</div>
<!--state overview end-->


@stop