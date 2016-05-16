<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use app\Helpers\MailQueueJobs;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\GetEmailQueue::class,
        \App\Console\Commands\GetEQDecider::class,

        #\App\Console\Commands\GetPoppedMessage::class,
        \App\Console\Commands\GetPMCampaign::class,
        \App\Console\Commands\GetPMSenderEmail::class,
        \App\Console\Commands\GetPMCDecider::class,
        \App\Console\Commands\GetPMSEDecider::class,

        \App\Console\Commands\SendEmailQueue::class,
        \App\Console\Commands\SEQDecider::class,

        \App\Console\Commands\ResetCount::class,
        \App\Console\Commands\SEmailCheck1::class,
        \App\Console\Commands\SEmailCheck2::class,
        \App\Console\Commands\SEmailCheck3::class,
        \App\Console\Commands\SEmailCheck4::class,
        \App\Console\Commands\SEmailCheck5::class,
        \App\Console\Commands\SEmailCheck6::class,
        \App\Console\Commands\SEmailCheck7::class,
        \App\Console\Commands\SEmailCheck8::class,
        \App\Console\Commands\SEmailCheck9::class,
        \App\Console\Commands\SEmailCheck10::class,
        \App\Console\Commands\SendEmailQueueToJobs::class,
        \App\Console\Commands\TgSend::class,
        \App\Console\Commands\CustomEmailSend::class,

        /*\App\Console\Commands\TgSend1::class,
        \App\Console\Commands\TgSend2::class,
        \App\Console\Commands\TgSend3::class,
        \App\Console\Commands\TgSend4::class,
        \App\Console\Commands\TgSend5::class,
        \App\Console\Commands\TgSend6::class,
        \App\Console\Commands\TgSend7::class,
        \App\Console\Commands\TgSend8::class,
        \App\Console\Commands\TgSend9::class,
        \App\Console\Commands\TgSend10::class,
        \App\Console\Commands\TgSend::class,*/
        \App\Console\Commands\TgSendDecider1::class,
        \App\Console\Commands\TgSendDecider2::class,
        \App\Console\Commands\TgSendDecider3::class,
        \App\Console\Commands\TgSendDecider4::class,
        \App\Console\Commands\TgSendDecider5::class,
        \App\Console\Commands\TgSendDecider6::class,
        \App\Console\Commands\TgSendDecider7::class,
        \App\Console\Commands\TgSendDecider8::class,
        \App\Console\Commands\TgSendDecider9::class,
        \App\Console\Commands\TgSendDecider10::class,


        \App\Console\Commands\FMDecider::class,
        \App\Console\Commands\FmSend::class,

        //command for Failed mail send
        /*\App\Console\Commands\FmSend1::class,
        \App\Console\Commands\FmSend2::class,
        \App\Console\Commands\FmSend3::class,
        \App\Console\Commands\FmSend4::class,
        \App\Console\Commands\FmSend5::class,
        \App\Console\Commands\FmSend6::class,
        \App\Console\Commands\FmSend7::class,
        \App\Console\Commands\FmSend8::class,
        \App\Console\Commands\FmSend9::class,
        \App\Console\Commands\FmSend10::class,*/
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        #$schedule->command('get:poppedmessage')->cron('*/3	* * * *');
        #$schedule->command('get:emailqueue')->cron('*/2	* * * *');
        #$schedule->command('set:emailsend')->cron('*/1	* * * *');

        //custom command
        #$schedule->command('get:poppedmessage')->everyMinute();
        $schedule->command('pmcdecider')->everyMinute();
        $schedule->command('pmsedecider')->everyMinute();

        /*$schedule->command('get:emailqueue')->everyMinute();*/
        $schedule->command('set:emailsend')->everyMinute();
        $schedule->command('get:emailqueuedecider')->everyMinute();
        $schedule->command('set:emailsenddecider')->everyMinute();

        $schedule->command('tgsenddecider1')->everyMinute();
        $schedule->command('tgsenddecider2')->everyMinute();
        $schedule->command('tgsenddecider3')->everyMinute();
        $schedule->command('tgsenddecider4')->everyMinute();
        $schedule->command('tgsenddecider5')->everyMinute();
        $schedule->command('tgsenddecider6')->everyMinute();
        $schedule->command('tgsenddecider7')->everyMinute();
        $schedule->command('tgsenddecider8')->everyMinute();
        $schedule->command('tgsenddecider9')->everyMinute();
        $schedule->command('tgsenddecider10')->everyMinute();

        //Call failed mail sending decider
        $schedule->command('fmdecider')->everyMinute();
        $schedule->command('fmsend1')->everyMinute();
        $schedule->command('fmsend2')->everyMinute();
        $schedule->command('fmsend3')->everyMinute();
        $schedule->command('fmsend4')->everyMinute();
        $schedule->command('fmsend5')->everyMinute();
        $schedule->command('fmsend6')->everyMinute();
        $schedule->command('fmsend7')->everyMinute();
        $schedule->command('fmsend8')->everyMinute();
        $schedule->command('fmsend9')->everyMinute();
        $schedule->command('fmsend10')->everyMinute();

        $schedule->command('emailcheck1')->hourly();
        $schedule->command('emailcheck2')->hourly();
        $schedule->command('emailcheck3')->hourly();
        $schedule->command('emailcheck4')->hourly();
        $schedule->command('emailcheck5')->hourly();
        $schedule->command('emailcheck6')->hourly();
        $schedule->command('emailcheck7')->hourly();
        $schedule->command('emailcheck8')->hourly();
        $schedule->command('emailcheck9')->hourly();
        $schedule->command('emailcheck10')->hourly();

        $schedule->command('set:resetcount')->dailyAt('23:59');
    }
}
