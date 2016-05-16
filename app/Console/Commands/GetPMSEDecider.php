<?php

namespace App\Console\Commands;

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

class GetPMSEDecider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pmsedecider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sender Email Popped Message Decider.';

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
        $campaign = Campaign::with('relPoppingEmail.relImap')->where('status', 'active')->get() ;

        foreach($campaign as $camp){
            // Call GetPMCampaign command with id
            //Artisan::call('pmcampaign', ['id' => $camp->id]);

            $sender_email = SenderEmail::with('relImap')
                ->where('popping_status', 'true')
                ->where('status','=', 'domain')
                ->where('campaign_id', $camp->id)
                ->get();

            foreach($sender_email as $values){
                // Call GetSenderEmail command with id
                Artisan::call('pmsenderemail', ['id' => $values->id]);
                print "Call of se: ".$values->id."\n";
            }
        }

        return true;
    }

}
