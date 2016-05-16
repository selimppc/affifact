<?php

namespace App\Console\Commands;

use App\Helpers\EmailSend;
use App\Helpers\GmailSendMessage;
use App\Helpers\Mailer;
use App\Helpers\SenderEmailCheck;
use App\Http\Controllers\SenderEmailController;
use App\MailFailed;
use App\SenderEmail;
use App\SendMailFailed;
use App\Smtp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class CustomEmailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:customEmailSend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom Email';

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
    public function handle(){

        SenderEmailController::set_max_email_send();
        exit;

        $se_email = SenderEmail::where('api_type', 'google')
            ->where('status', 'public')
            ->where('count', '<', 'max_email_send')
            ->get();
        $selected_se = null;
        foreach($se_email as $se){
            $result = GmailSendMessage::re_check_gmail_authentication($se->auth_token);
            if($result == 'valid'){
                $selected_se = $se;
                break;
            }
        }
        print_r($selected_se);exit();

        /*Config::set('mail.driver', 'smtp');
        Config::set('mail.host', 'smtp.mailgun.org');
        Config::set('mail.port', 587);
        Config::set('mail.from', ['address' => 'info@edutechsolutionsbd.com', 'name' => 'Info']);
        Config::set('mail.encryption', 'tls');
        Config::set('mail.username', 'postmaster@edutechsolutionsbd.com');
        Config::set('mail.password', '8020b7f27c67f2a7b0dd53825f18904f');
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);
        try{
            Mail::raw('Test Email from MaiGun!', function($message)
            {
                $message->from('info@edutechsolutionsbd.com', 'Info');
                $message->to('me@selimreza.com');
                $message->subject('Hello user');
                $message->replyTo('info@edutechsolutionsbd.com', 'Info');
            });
            print "Success !!\n";
        }catch(\Exception $e){
            print "Email not send ".$e->getMessage()."\n";
        }*/

        /*//directory make
        $dir = public_path();
        if(file_exists($dir)){
            if(fileperms($dir) != 0755){
                umask(0);
                chmod($dir, 0755);
            }
            $fl = '/';
        }else{
            umask(0);  // helpful when used in linux server
            mkdir ($dir, 0755);
            $fl = '/';
        }

        $dir = $dir."/uploads";
        if ( !file_exists($dir) ) {
            umask(0);  // helpful when used in linux server
            mkdir ($dir, 0755);
            $fl = '/uploads';
        }else{
            $fl = '/uploads';
        }

        $dir = $dir."/campaign_se";
        if ( !file_exists($dir) ) {
            umask(0);  // helpful when used in linux server
            mkdir ($dir, 0755);
            $fl = '/uploads/campaign_se';
        }else{
            $fl = '/uploads/campaign_se';
        }

        $file_name_gen = uniqid().".txt";
        $file_name = $dir.'/'.$file_name_gen;
        $file_link =URL::to($fl.'/'.$file_name_gen);
        $handle = fopen($file_name, "w");
        $not_deleted_emails_for_domain = [
            'nhsajib',
            'nhsajib2',
            'nhsajib3',
            'nhsajib4',
        ];

        foreach($not_deleted_emails_for_domain as $arr)
        {
            fwrite($handle, $arr."\r\n");
        }
        fclose($handle);
        print $dir."\n";
        print $file_name."\n";
        print $file_link."\n";*/

        exit;

        $mail_config_data = Smtp::where('id',2)->first();

        /*print_r(Config::get('mail'));
        exit("OOO");
        $host = Config::get('mail.host');
        $port = Config::get('mail.port');
        $username = Config::get('mail.username');
        $password = Config::get('mail.password');
        */

        /*$ret = $this->EmailValidationCheck('a2plcpnl0336.prod.iad2.secureserver.net', 'britney-fiona@meetnsafe.co', 'britney-fiona@');
        var_dump($ret);exit;*/
        $message = [
            "This is message 1",
            "This is message 2",
            "This is message 3",
            "This is message 4",
            "This is message 5",
        ];
       /* $emails ="devdhaka404@mail.ru";

                $this->SendEmails($emails,$message);*/

        $emails = [
            "gmail" => [
                "devdhaka404@gmail.com",
                "devdhaka405@gmail.com",
                "devdhaka406@gmail.com",
                "devdhaka407@gmail.com",
                "devdhaka408@gmail.com"
            ],
            "yahoo" => [
                "devdhaka404@yahoo.com",
                "devdhaka405@yahoo.com",
                "devdhaka406@yahoo.com",
                "devdhaka407@yahoo.com",
                "devdhaka408@yahoo.com",
            ],
            "gmx" => [
                "devdhaka404@gmx.com",
                "devdhaka405@gmx.com",
                "devdhaka406@gmx.com",
                "devdhaka407@gmx.com",
                "devdhaka408@gmx.com"
            ],
            "mailru" => [
                "devdhaka404@mail.ru",
                "devdhaka405@mail.ru",
                "devdhaka406@mail.ru",
                "devdhaka407@mail.ru",
                "devdhaka408@mail.ru"
            ],
            "aol" => [
                "devdhaka404@aol.com",
                "devdhaka405@aol.com",
                "devdhaka406@aol.com",
                "devdhaka407@aol.com",
                "devdhaka409@aol.com"
            ],
            "yandex" => [
                "devdhaka404@yandex.com",
                "devdhaka405@yandex.com",
                "devdhaka406@yandex.com",
                "devdhaka407@yandex.com",
                "devdhaka408@yandex.com"
            ],
            "mailcom" =>[
                "devdhaka405@mail.com",
                "devdhaka406@mail.com",
                "devdhaka407@mail.com",
                "devdhaka408@mail.com",
                "devdhaka409@mail.com"
            ]
        ];

        $start_time = date('Y-m-d H:i:s');
        print "Start Time: ".$start_time."\n";
        for($i=0; $i < 5; $i++){
            for($j = 0; $j < 5; $j++){
                $this->msend($emails["gmail"][$j],  $message[$i], $i);
                $this->msend($emails["yahoo"][$j],  $message[$i], $i);
                $this->msend($emails["gmx"][$j],    $message[$i], $i);
                $this->msend($emails["mailru"][$j], $message[$i], $i);
                $this->msend($emails["aol"][$j],    $message[$i], $i);
                $this->msend($emails["yandex"][$j], $message[$i], $i);
                $this->msend($emails["mailcom"][$j],$message[$i], $i);
            }
        }
        $end_time = date('Y-m-d H:i:s');
        print "End Time: ".$end_time."\n";
    }

    public function SendEmails($to_email, $body){
        $from_email= 'britney-fiona10@meetnsafe.co';
        $from_name = 'Meet n Safe';
        $subject = 'Meet n Safe';
        $reply_to = 'britney-fiona10@meetnsafe.co';
        $reply_to_name = 'Meet n Safe';

        for($i=0; $i < count($body); $i++){
            $msgg  = $body[$i];

            echo date('Y-m-d H:i:s');
            echo "---";

            Mail::send('email_template.common', array('body'=>$msgg), function ($message) use($from_email, $from_name, $to_email, $subject,$reply_to, $reply_to_name, $msgg) {
                $message->from($from_email, $from_name);
                $message->to($to_email);
                $message->subject($subject);
                $message->replyTo($reply_to, $name = $reply_to_name);
                $message->setBody($msgg, 'text/html');
            });

            echo date('Y-m-d H:i:s');
            echo "--- ... --";
        }
    }

    private function msend($to_email, $body, $index){

        $from_email= 'devdhaka404@yahoo.com';
        $from_name = 'Meet n Safe';
        $subject = 'Meet n Safe';
        $reply_to = 'devdhaka404@yahoo.com';
        $reply_to_name = 'Meet n Safe';
        /*$smtp = [
            [
                "host" => 'a2plcpnl0336.prod.iad2.secureserver.net',
                "username" => 'britney-fiona1@meetnsafe.co',
                "password" => 'britney-fiona@'
            ],
            [
                "host" => 'a2plcpnl0336.prod.iad2.secureserver.net',
                "username" => 'britney-fiona2@meetnsafe.co',
                "password" => 'britney-fiona@'
            ],
            [
                "host" => 'a2plcpnl0336.prod.iad2.secureserver.net',
                "username" => 'britney-fiona3@meetnsafe.co',
                "password" => 'britney-fiona@'
            ],
            [
                "host" => 'a2plcpnl0336.prod.iad2.secureserver.net',
                "username" => 'britney-fiona5@meetnsafe.co',
                "password" => 'britney-fiona@'
            ],
            [
                "host" => 'a2plcpnl0336.prod.iad2.secureserver.net',
                "username" => 'britney-fiona10@meetnsafe.co',
                "password" => 'britney-fiona@'
            ],
        ];

        /*
             * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all

        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', $smtp[$index]['host']);
        Config::set('mail.port', 465);
        Config::set('mail.from', ['address' => $from_email, 'name' => $from_name]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $smtp[$index]['username']);
        Config::set('mail.password', $smtp[$index]['password']);
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);*/

        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', 'smtp.mail.yahoo.com');
        Config::set('mail.port', 465);
        Config::set('mail.from', ['address' => $from_email, 'name' => $from_name]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $from_email);
        Config::set('mail.password', 'etsb1234');
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);

        try{
            // Start time
            $start_time = date('Y-m-d H:i:s');
            Mail::send('email_template.common', array('body'=>$body), function ($message) use($from_email, $from_name, $to_email, $subject,$reply_to, $reply_to_name, $body) {
                $message->from($from_email, $from_name);
                $message->to($to_email);
                $message->subject($subject);
                $message->replyTo($reply_to, $name = $reply_to_name);
                $message->setBody($body, 'text/html');

                /*if(count($file_name)>0){
                    $size = sizeOf($file_name); //get the count of number of attachments
                    for($i=0; $i< $size; $i++){
                        $message->attach($file_name[$i]);
                    }
                }*/

            });
            //end time
            $end_time = date('Y-m-d H:i:s');
            //print in console----------
            print  "Send To: ".$to_email."->Send From: ".$from_email."->Message: ".$body."->Success: [StartTime: ".$start_time." EndTime: ".$end_time."]\n";
        } catch(\Exception $e){
            $end_time = date('Y-m-d H:i:s');

            //eamil send failed save in send_mail_failed table-----------------
            $desc = "Send To: ".$to_email."->Message: ".$e->getMessage()."->Not Send: [StartTime: ".$start_time." EndTime: ".$end_time."]\n";
            $mailFailed = new SendMailFailed();
            $mailFailed->host = Config::get('mail.host');
            $mailFailed->port = Config::get('mail.port');
            $mailFailed->from_email = $from_email;
            $mailFailed->from_name = $from_name;
            $mailFailed->username = Config::get('mail.username');
            $mailFailed->password = Config::get('mail.password');
            $mailFailed->to_email = $to_email;
            $mailFailed->subject = $subject;
            $mailFailed->body = $body;
            $mailFailed->file_name = null;
            $mailFailed->reply_to = $reply_to;
            $mailFailed->start_time = $start_time;
            $mailFailed->end_time = $end_time;
            $mailFailed->msg = $e->getMessage();
            $mailFailed->save();
            //print in console-------
            print "Send To: ".$to_email."->Send From: ".$from_email."->Message: ".$e->getMessage()."->Not Send: [StartTime: ".$start_time." EndTime: ".$end_time."]\n";
        }
    }

    private function EmailValidationCheck($hostname,$username,$password){

        $hostname = '{'.$hostname.':993/imap/ssl/novalidate-cert}INBOX';

        $inbox = @imap_open($hostname,$username,$password);

        if(imap_errors()){
            $inbox = false;
        }else{
            $inbox = true;
        }

        return $inbox;
    }
}
