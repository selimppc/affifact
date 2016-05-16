<?php

namespace App\Console\Commands;
use App\SendMailFailed;
use App\TmpGarbage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

use App\PoppedMessageHeader;
use App\PoppingEmail;
use App\Campaign;
use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\Message;
use App\PoppedMessageDetail;
use App\Smtp;
use App\SubMessage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReminderEmail;
use Illuminate\Bus\Queueable;

use App\EmailQueue;
use App\SenderEmail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Xmlapi;
use App\FollowupMessage;


use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;

use Illuminate\Support\Facades\Artisan;

class TgSendDecider10 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tgsenddecider10';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TgSend Decider 10.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tg_data = TmpGarbage::orderBy('id', 'ASC')
            ->skip(90)
            ->take(10)
            ->get();

        /*foreach($tg_data as $values){
            Artisan::call('tgsend', ['id' => $values->id]);
            print "Call Of TgSend from Decider 10: ".$values->id."\n";
            sleep(2);
        }*/
        if(isset($tg_data[0])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[0]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[0]->id]);
            sleep(2);
        }
        if(isset($tg_data[1])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[1]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[1]->id]);
            sleep(2);
        }
        if(isset($tg_data[2])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[2]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[2]->id]);
            sleep(2);
        }
        if(isset($tg_data[3])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[3]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[3]->id]);
            sleep(2);
        }
        if(isset($tg_data[4])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[4]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[4]->id]);
            sleep(2);
        }
        if(isset($tg_data[5])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[5]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[5]->id]);
            sleep(2);
        }
        if(isset($tg_data[6])) {
            Artisan::call('tgsend', ['id' => $tg_data[6]->id]);
            print "Call Of TgSend from Decider 10: " . $tg_data[6]->id . "\n";
            sleep(2);
        }
        if(isset($tg_data[7])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[7]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[7]->id]);
            sleep(2);
        }
        if(isset($tg_data[8])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[8]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[8]->id]);
            sleep(2);
        }
        if(isset($tg_data[9])) {
            print "Call Of TgSend from Decider 10: " . $tg_data[9]->id . "\n";
            Artisan::call('tgsend', ['id' => $tg_data[9]->id]);
        }

        return true;
    }

}
