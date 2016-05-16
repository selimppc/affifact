<?php

namespace App\Console\Commands;

use App\Helpers\SenderEmailCheck;
use Illuminate\Console\Command;
use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\PoppedMessageDetail;
use App\SubMessage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Socialite;

use App\EmailQueue;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\Helpers\EmailSend;
use DB;

class SEmailCheck1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailcheck1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        /*$sender_email_update = SenderEmail::findOrFail(2232);
        $sender_email_update->count = $sender_email_update->count +1;
        $sender_email_update->update();
        exit;*/
        DB::enableQueryLog();
        $sender_emails = SenderEmail::with('relImap')
            ->where('status', '!=', 'invalid')
            ->whereRaw('api_type IS NULL')
            ->orderBy('updated_at', 'ASC')
            ->skip(0)
            ->take(100)
            ->get();


        #dd(DB::getQueryLog());
        #print_r($sender_emails);exit;
        foreach($sender_emails as $se){
            print $se->id." : ";
            print $se->updated_at."\n";
            print "Start : ".date("Y-m-d H:i:s")."\n";
            $ret = SenderEmailCheck::sender_email_checking($se->id);
            print "End : ".date("Y-m-d H:i:s")."\n";
        }
    }
}
