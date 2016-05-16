<?php

namespace App\Console\Commands;
use App\SendMailFailed;
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

class FMDecider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fmdecider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Failed Mail Decider.';

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
        $fm_data = SendMailFailed::orderBy('no_of_try', 'ASC')
            ->orderBy('id', 'ASC')
            ->take(10)
            ->get();

        /*foreach($fm_data as $values){
            Artisan::call('fmsend', ['id' => $values->id]);
            print "Call of FM: ".$values->id."\n";
            sleep(2);
        }*/
        if(isset($fm_data[0])) {
            Artisan::call('fmsend', ['id' => $fm_data[0]->id]);
            print "Call of FM: " . $fm_data[0]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[1])) {
            Artisan::call('fmsend', ['id' => $fm_data[1]->id]);
            print "Call of FM: " . $fm_data[1]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[2])) {
            Artisan::call('fmsend', ['id' => $fm_data[2]->id]);
            print "Call of FM: " . $fm_data[2]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[3])) {
            Artisan::call('fmsend', ['id' => $fm_data[3]->id]);
            print "Call of FM: " . $fm_data[3]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[4])) {
            Artisan::call('fmsend', ['id' => $fm_data[4]->id]);
            print "Call of FM: " . $fm_data[4]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[5])) {
            Artisan::call('fmsend', ['id' => $fm_data[5]->id]);
            print "Call of FM: " . $fm_data[5]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[6])) {
            Artisan::call('fmsend', ['id' => $fm_data[6]->id]);
            print "Call of FM: " . $fm_data[6]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[7])) {
            Artisan::call('fmsend', ['id' => $fm_data[7]->id]);
            print "Call of FM: " . $fm_data[7]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[8])) {
            Artisan::call('fmsend', ['id' => $fm_data[8]->id]);
            print "Call of FM: " . $fm_data[8]->id . "\n";
            sleep(2);
        }
        if(isset($fm_data[9])) {
            Artisan::call('fmsend', ['id' => $fm_data[9]->id]);
            print "Call of FM: " . $fm_data[9]->id . "\n";
            #sleep(2);
        }

        return true;
    }

}
