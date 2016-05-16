<?php

namespace App\Http\Controllers;

use App\Filter;
use App\Helpers\EmailSend;
use App\Helpers\GmailSendMessage;
use App\Helpers\SenderEmailCheck;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\SubMessageAttachment;
use DB;
use Illuminate\Support\Facades\Config;
use Session;
use App\Helpers\Xmlapi;
use App\Imap;
use App\Smtp;
use Illuminate\Support\Facades\Input;
use Queue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserResetPassword;
use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Laravel\Socialite\Facades\Socialite;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;
use Illuminate\Contracts\Mail\MailQueue;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('email')) {
            return redirect()->route('home-dashboard');
        }
        else{
            return view('user.login.login');
        }
    }

//layouts..
    public function layout_box_page()
    {
        return view('pages.layouts.box_page');
    }

    public function layout_horizontal_menu()
    {
        return view('pages.layouts.horizontal_menu');
    }

    public function layout_language_switch_bar()
    {
        return view('pages.layouts.language_switch_bar');
    }
//UI-elements..
    public function elements_general()
    {
        return view('pages.ui_elements.general');
    }

    public function elements_buttons()
    {
        return view('pages.ui_elements.button');
    }

    public function elements_widget()
    {
        return view('pages.ui_elements.widget');
    }

    public function elements_slider()
    {
        return view('pages.ui_elements.slider');
    }

    public function elements_nestable()
    {
        return view('pages.ui_elements.nestable');
    }

    public function elements_font_awesome()
    {
        return view('pages.ui_elements.font_awesome');
    }
//component...
    public function component_grid()
    {
        return view('pages.component.grid');
    }

    public function component_calender()
    {
        return view('pages.component.calender');
    }

    public function component_gallery()
    {
        return view('pages.component.gallery');
    }

    public function component_todo_list()
    {
        return view('pages.component.todo_list');
    }
//form_stuff
    public function stuff_form_components()
    {
        return view('pages.form_stuff.form_components');
    }

    public function stuff_adv_components()
    {
        return view('pages.form_stuff.adv_components');
    }

    public function stuff_dropzone_file_upload()
    {
        return view('pages.form_stuff.dropzone_file_upload');
    }

    public function stuff_form_validation()
    {
        return view('pages.form_stuff.form_validation');
    }

    public function stuff_form_wizard()
    {
        return view('pages.form_stuff.form_wizard');
    }

    public function stuff_image_cropping()
    {
        return view('pages.form_stuff.image_cropping');
    }

    public function stuff_inline_editor()
    {
        return view('pages.form_stuff.inline_editor');
    }

    //data-tables...

    public function data_tables_adv()
    {
        return view('pages.data_tables.advanced');
    }

    public function data_tables_basic()
    {
        return view('pages.data_tables.basic');
    }

    public function data_tables_dynamic()
    {
        return view('pages.data_tables.dynamic');
    }

    public function data_tables_editable()
    {
        return view('pages.data_tables.editable');
    }

    public function data_tables_responsive()
    {
        return view('pages.data_tables.responsive');
    }

    //mail..
    public function mail()
    {
        return view('pages.mail._mail');
    }

    //charts....
    public function chart_js()
    {
        return view('pages.charts.chartjs');
    }
    public function chart_flot()
    {
        return view('pages.charts.flot_chart');
    }
    public function chart_morris()
    {
        return view('pages.charts.morris');
    }
    public function chart_x()
    {
        return view('pages.charts.x_chart');
    }

    //shop....
    public function shop_list_view()
    {
        return view('pages.shop.list_view');
    }
    public function shop_details_view()
    {
        return view('pages.shop.details_view');
    }

    //google-map...
    public function google_map()
    {
        return view('pages.google_map._google_map');
    }

    //extra....
    public function extra_404_error()
    {
        return view('pages.extra.404_error');
    }
    public function extra_500_error()
    {
        return view('pages.extra.500_error');
    }
    public function extra_blank_page()
    {
        return view('pages.extra.blank_page');
    }
    public function extra_invoice()
    {
        return view('pages.extra.invoice');
    }
    public function extra_lock_screen()
    {
        return view('pages.extra.lock_screen');
    }
    public function extra_profile()
    {
        return view('pages.extra.profile');
    }
    public function extra_search_result()
    {
        return view('pages.extra.search_result');
    }

    //login....
    /*public function login()
    {
        return view('pages.login._login');
    }*/

    //multilevel-menu....
    public function menu_item_1()
    {
        return view('pages.menu.item_1');
    }
    public function menu_item_2()
    {
        return view('pages.menu.item_2');
    }


    /*
     *
     * Form Validation
     */
    public function form_validation(){
        return view('form_validation.form_valid');
    }

    public function new_advanced_form(){
        return view('form_validation.advanced_form');
    }

    public function modal_form(){
        return view('test.modal');
    }


    /*
     *
     * Mail Queue : Delay
     *
     */
    public function send_email_with_delay()
    {
        $input = [
            'name' => 'Mario Basic',
            'email' => 'nhsajib316@gmail.com',
            'comment' =>  'Testing queues',
            'subject' =>  'Email subject'
        ];


        try {
            Mail::queue('home.email', array(''), function ($message) {
                $message->from('bdcode404@gmail.com', 'Nadim');
                $message->to('bdcode404@gmail.com');
                $message->subject('Test New');
            });
        }
        catch(\Exception $e){
            return "Not send";
        }

        return "successfully send";
    }


    /*
     * Generate email account in cpanel
     *
     *
     */



    public function home_reminder_mail()
    {
        $email = 'admin@admin.com';
        $user_exists = DB::table('user')->where('email', '=', $email)->exists();

        if($user_exists){
            $user = DB::table('user')->where('email', '=', $email)->first();

            $model = new UserResetPassword();
            $model->user_id = $user->id;
            $model->reset_password_token = str_random(30);
            $token = $model->reset_password_token;
            $model->reset_password_expire = date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s', time())) + (60 * 30)));
            $model->reset_password_time = date('Y-m-d H:i:s', time());
            $model->status = 2;


            if($model->save()) {
                try{
                    Mail::send('user.forgot_password.email_notification', array('link' =>$token),
                        function($message) use ($user)
                        {
                            $message->from('test@edutechsolutionsbd.com', 'AFFIFACT');
                            $message->to($user->email);
                            $message->cc('tanintjt@gmail.com', 'Tanin');
                            $message->subject('Forgot Password Reset Mail');
                        });
                    Session::flash('flash_message', 'Sent email with reset password. Please check your email!');
                }catch (\Exception $e){
                    Session::flash('flash_message_error', 'Email does not Send!');
                }

            }else{
                Session::flash('flash_message_error', 'Does not Save!');
            }
            #return view('user.forgot_password.flash_message');
        }else{
            Session::flash('flash_message_error', 'The Specified Email address Is not Listed On Your Account. Please Try Again.');
            exit("Account nai tomar");
        }
        return redirect('user/dashboard');


    }




    public function check_keyword_exists(){
        #$list =array('postmaster', 'no-reply', 'cheese', 'milk');
        $filter_list= DB::table('filter')->select('name')->get();
        foreach($filter_list as $filter){
            $list []= [
                'name' => $filter->name,
            ];
        }
        $text ='no-reply@gmail.com';

        $match = 0;
        foreach ($list[0] as $word) {
            // This pattern takes care of word boundaries, and is case insensitive
            $pattern = "/\b$word\b/i";
            $match += preg_match($pattern, $text);
        }
        print_r($match);
        exit;
    }



    public function settings()
    {
        $pageTitle = " System Settings";
        return view('settings.setup', [
            'pageTitle'=>$pageTitle
        ]);
    }



    public function test_ldap(){

        $status = SenderEmailCheck::sender_email_checking(1);

        print_r($status);exit;

        $host ='smtp.gmail.com';
        $port ='465';
        $from_email ='devdhaka404@gmail.com';
        $from_name  ='Selim Reza from Ha ha ha ';
        $username  ='devdhaka404@gmail.com';
        $password  ='etsb1234';
        $to_email  ='shajjad84@gmail.com';
        $subject  ="Yahoo :::: password change koren 'asdf@123456';";
        $body = "Vai apnar password change koren 'asdf@123456'  @ Yahoo :::: ";

        $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body);
        print_r($result);exit;

        $username = escapeshellarg('different');
        $password = escapeshellarg('different');
        #$udomain = 'edutechsolutionsbd.com';
        $u_domain = '192.168.0.100';
        $u_user = 'etsb';

        $output = exec("sudo shell_script/add_user.sh $username $password $u_domain $u_user 2>&1");
        #$output = shell_exec("/usr/bin/php -v");
        print_r($output);
        exit;

    }





    /*
     * This would be in Kernel Consol
     *
     */

    public function reply_email($id){

        $popped_message_id = $id;
        $popped_message = PoppedMessageHeader::findOrFail($popped_message_id);
        $campaign_id = $popped_message->campaign_id;
        $camp_exists = Campaign::where('id', $campaign_id)->where('status', 'active')->exists();

        if($camp_exists){

            $sender_email = SenderEmail::where('campaign_id', $campaign_id)
                ->where('status','!=', 'invalid')
                ->first();
            #print_r($sender_email);exit;
            /*
             * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all
             */

            Config::set('mail.driver', 'smtp');
            Config::set('mail.host', $sender_email->relSmtp->host);
            Config::set('mail.port', 465);
            Config::set('mail.from', ['address' => $sender_email->email, 'name' => $sender_email->name]);
            Config::set('mail.encryption', 'ssl');
            Config::set('mail.username', $sender_email->email);
            #Config::set('mail.username', 'test@edutechsolutionsbd.com');
            Config::set('mail.password', $sender_email->password);
            #Config::set('mail.password', 'edutech@123');
            Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
            Config::set('mail.pretend', false);
            #Config::set('mail.encryption', $sender_email->relSmtp->secure);

            // Start transaction
            DB::beginTransaction();
            try{
                Mail::send('pages.test', array(''), function ($message) use($popped_message, $sender_email) {
                    $message->from($popped_message->user_email);
                    $message->to($popped_message->user_email);
                    $message->subject('RE: Reply of Popped Message.');
                });


                //Popping Status in sender_email table
                $sm_model = SenderEmail::findOrNew($sender_email->id);
                $sm_model->popping_status = 'true';
                $sm_model->save();

                //Commit
                DB::commit();
                Session::flash('flash_message', 'Sent First Message to : '.$popped_message->user_email);
            }catch (\Exception $e){
                DB::rollback();
                Session::flash('flash_message_error', $e->getMessage());
            }
        }else{
            Session::flash('flash_message_error', 'Campaign is not Activated yet!');
        }
        return redirect('popped-message');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home_dashboard(){

        #$se_limit_check = GmailSendMessage::limit_check_for_sender_email($from_email);

        $pageTitle = " Welcome to Affi Fact";
        $now = date('Y-m-d H:i:s');
        $last_24 = date('Y-m-d H:i:s', time() - 86400);

        // Last 24 hours data
        $mail_read_total = DB::table('popped_message_detail as read_dt')
            ->whereNull('read_dt.sub_message_id')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->where('d_status', '=', 'mail-read')
            ->whereBetween('read_dt.created_at', [$last_24, $now])
            ->count('read_dt.id');

        $mail_sent_total = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->where('d_status', '=', 'mail-sent')
            ->whereBetween('read_dt.created_at', [$last_24, $now])
            ->count('read_dt.id');

        // Campaign wise send
        $campaign_wise_data_mail_sent = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->where('read_dt.d_status', '=', 'mail-sent')
            ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_sent'))
            ->groupBy('cp.id')
            ->get();

        //only campaign wise mail read --------------------------------
        $campaign_wise_data_mail_read =
            DB::table('popped_message_detail as read_dt')
                ->join('popped_message_header as hd', function ($join) {
                    $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
                })
                ->join('campaign as cp', function ($join) {
                    $join->on('hd.campaign_id', '=', 'cp.id');
                })
                ->join('sender_email as se', function ($join) {
                    $join->on('hd.sender_email_id', '=', 'se.id');
                })
                ->join('smtp as smtp', function ($join) {
                    $join->on('se.smtp_id', '=', 'smtp.id');
                })
                ->where('read_dt.d_status', '=', 'mail-read')
                ->select(DB::raw('cp.id as campaign_id, count(read_dt.id) as mail_read'))
                ->groupBy('cp.id')
                ->paginate(100);

        // Sender Email wise read count
        $sender_email_wise_camp_mail_read = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('popping_email as pe', function ($join) {
                $join->on('cp.popping_email_id', '=', 'pe.id');
            })
            /* no need to pcik any data from here else this condition will not be delivered
             * ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id')
                     ->on('cp.id', '=', 'se.campaign_id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })*/
            ->where('read_dt.d_status','=','mail-read')
            ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, read_dt.sender_email as sender_email, pe.email as popping_email'))
            ->groupBy('read_dt.sender_email')
            ->paginate(100);

        // Sender Email wise sent count
        $sender_email_wise_camp_mail_sent = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('read_dt.sender_email', '=', 'se.email')
                    ->on('cp.id', '=', 'se.campaign_id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->where('read_dt.d_status','=','mail-sent')
            ->select(DB::raw('count(read_dt.id) as mail_sent,se.email as sender_email'))
            ->groupBy('se.id')
            ->paginate(100);

        // Sender Email wise email
        $sender_email_wise_camp = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('campaign as cp', function ($join) {
                $join->on('hd.campaign_id', '=', 'cp.id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('read_dt.sender_email', '=', 'se.email')
                     ->on('cp.id', '=', 'se.campaign_id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->groupBy('se.id', 'cp.id')
            ->select(DB::raw('cp.id as campaign_id, se.email as sender_email, se.count as count, smtp.mails_per_day_per_email as mails_per_day_per_email'))
            ->paginate(100);

        return view('home.dashboard_new', [
            'mail_read_total'=>$mail_read_total,
            'mail_sent_total'=>$mail_sent_total,
            'campaign_wise_data_mail_read'=>$campaign_wise_data_mail_read,
            'campaign_wise_data_mail_sent'=>$campaign_wise_data_mail_sent,
            'sender_email_wise_camp_mail_sent'=>$sender_email_wise_camp_mail_sent,
            'sender_email_wise_camp_mail_read'=>$sender_email_wise_camp_mail_read,
            'sender_email_wise_camp'=>$sender_email_wise_camp,

            'pageTitle'=> $pageTitle
        ]);
    }



    public function google_login_api(){

        /*$client_id = '590108288857-5pupadvvc9h2bbg2nnrtt6mvnjdofvfs.apps.googleusercontent.com';
        $client_secret = '8Y_9AUY2M4zfr9InJFlN-fJf';
        #$redirect_uri = 'http://local.gauth.com/user-example.php';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        #$client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/urlshortener");


        $response = new Google_Service_Gmail_ModifyMessageRequest();
        #print_r($response);exit;

        $userId = "devdhaka404@gmail.com";
        $messageId = '1510a463e632bce0';
        $service = new Google_Service_Gmail($client);


        $mods = new Google_Service_Gmail_ModifyMessageRequest();
        #$mods->setAddLabelIds($labelsToAdd);
        #$mods->setRemoveLabelIds($labelsToRemove);
        try {
            $message = $service->users_messages->modify($userId, $messageId, $mods);
            print 'Message with ID: ' . $messageId . ' successfully modified.';
            print_r($message);
        } catch (Exception $e) {
            print 'An error occurred: ' . $e->getMessage();
        }

        print_r("OK");

        exit("OK");*/














        //PHP - Get Gmail new messages (unread) from Atom Feed

        $username = urlencode('devdhaka404@gmail.com');
        $password = 'etsb1234';
        $tag = 'UNREAD';

        $handle = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYHOST => '0',
            CURLOPT_SSL_VERIFYPEER => '1',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_VERBOSE        => true,
            CURLOPT_URL            => 'https://'.$username.':'.$password.'@mail.google.com/mail/feed/atom/'.$tag,
        );

        curl_setopt_array($handle, $options);
        $output = (string)curl_exec($handle);
        $xml = simplexml_load_string($output);

        if (curl_errno($handle)) {
            echo 'Error: ' . curl_error($handle);
        }
        curl_close($handle);

        $dt = array();
        for($i=0; $i<count($xml->entry); $i ++){
            $parts = parse_url((string)$xml->entry[$i]->link['href']);
            parse_str($parts['query'], $query);

            $dt []= array(
                'subject' => (string)$xml->entry[$i]->title,
                'user_name' => (string)$xml->entry[$i]->author->name,
                'user_email' => (string)$xml->entry[$i]->author->email,
                'user_id' => (string)$xml->entry[$i]->id,
                'body_message' => (string)$xml->entry[$i]->summary,
                'modified' => (string)$xml->entry[$i]->modified,
                'message_id' => $query['message_id'],
            );


            /*$url_post = 'https://www.googleapis.com/gmail/v1/users/'.$dt[$i]['user_email'].'/messages/'.$dt[$i]['message_id'].'/modify';
            echo $url_post."<br>";
            $ch = curl_init( $url_post );
            $response = (string)curl_exec( $ch );
            #$read = simplexml_load_string($response);
            curl_close($ch);
            print_r($response); exit;*/

        }

        print_r($dt);
    }


    public function test_gmail_api(){
        $scopes = [
            'https://www.googleapis.com/auth/plus.profile.email_template.read',
            'https://mail.google.com/',
            'https://www.googleapis.com/auth/gmail.modify',
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/gmail.labels',
        ];
        $data = Socialite::with('google')->redirect();

        exit($data);
    }


    public function providerLogin($provider = 'google')
    {

        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));




        /*$client = new Google_Client();
        $client->setClientId("590108288857-5pupadvvc9h2bbg2nnrtt6mvnjdofvfs.apps.googleusercontent.com");
        $client->setClientSecret("SI2Od4cbEI7271hfzIV3Esrb");
        $client->setApplicationName('gmail-auth');
        $client->setScopes(SCOPES);
        $client->setAccessType('offline');*/


        $serviceId = 'account-1@g-api-1131.iam.gserviceaccount.com';
        $client = new \Google_Client(); // Initialize new Google Client class
        $clientSecretKey = file_get_contents('apis/my_project_8910357053cf.p12'); // Get string from
        $client->setScopes(SCOPES);
        $assertions = new \Google_Auth_AssertionCredentials($serviceId, SCOPES, $clientSecretKey);
        $client->setAssertionCredentials($assertions);

        $gmail = new \Google_Service_Gmail($client);
        #$serviceConnection = new \Google_Service_Analytics($client);
        $label = $gmail->users_labels->get('me', 'INBOX');
        print_r($label);exit;


        #$access_token = $this->getToken();

        // $googleClient is an authenticated instance of 'Google_Client'
        $gmail = new \Google_Service_Gmail($client);
        $label = $gmail->users_labels->get('devdhaka404@gmail.com', 'INBOX');
        $unreadCount = $label->messagesUnread;

        print_r($unreadCount);exit;



        #print_r($_REQUEST);
        /************************************************
        ATTENTION: Fill in these values! Make sure
        the redirect URI is to this page, e.g:
        http://localhost:8080/user-example.php
         ************************************************/
        $client_id = '590108288857-5pupadvvc9h2bbg2nnrtt6mvnjdofvfs.apps.googleusercontent.com';
        $client_secret = '8Y_9AUY2M4zfr9InJFlN-fJf';
        $redirect_uri = 'http://dev.affifact.com/providerLogin';

        /************************************************
        Make an API request on behalf of a user. In
        this case we need to have a valid OAuth 2.0
        token for the user, so we need to send them
        through a login flow. To do this we need some
        information from our API console project.
         ************************************************/
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
#$client->addScope("https://www.googleapis.com/auth/urlshortener");

        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));
//print_r(SCOPES);exit;
        $client->setScopes(SCOPES);

        /************************************************
        When we create the service here, we pass the
        client to it. The client then queries the service
        for the required scopes, and uses that when
        generating the authentication URL later.
         ************************************************/
        $service = new Google_Service_Urlshortener($client);

        /************************************************
        If we're logging out we just need to clear our
        local access token in this case
         ************************************************/
        /*if (isset($_REQUEST['logout'])) {
            unset($_SESSION['access_token']);
        }*/

        /************************************************
        If we have a code back from the OAuth 2.0 flow,
        we need to exchange that with the authenticate()
        function. We store the resultant access token
        bundle in the session, and redirect to ourself.
         ************************************************/
        if (isset($_GET['code'])) {
            //$client->authenticate($_GET['code']);

            $_SESSION['access_token'] = $client->getAccessToken();
            print_r($_SESSION['access_token']);
            exit("code");

            print_r($_REQUEST);echo('<br><br>');
            print_r($_SESSION['access_token']);
            exit;
            //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
//exit('PPPP');
        /************************************************
        If we have an access token, we can make
        requests, else we generate an authentication URL.
         ************************************************/
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        } else {
            $authUrl = $client->createAuthUrl();
        }

        /************************************************
        If we're signed in and have a request to shorten
        a URL, then we create a new URL object, set the
        unshortened URL, and call the 'insert' method on
        the 'url' resource. Note that we re-store the
        access_token bundle, just in case anything
        changed during the request - the main thing that
        might happen here is the access token itself is
        refreshed if the application has offline access.
         ************************************************/
        if ($client->getAccessToken() && isset($_GET['url'])) {
            $url = new Google_Service_Urlshortener_Url();
            $url->longUrl = $_GET['url'];
            $short = $service->url->insert($url);
            $_SESSION['access_token'] = $client->getAccessToken();
        }

        /*$client->setScopes(array(
            'https://mail.google.com/',
            'https://www.googleapis.com/auth/gmail.compose',
            'https://www.googleapis.com/auth/gmail.readonly'
        ));*/

#exit($client->getAccessToken());
#$client->authenticate('4/pbORm2cEl2ZOytOAUdXFbvtv7iIXTXonaPjWupFmqJw');
        $client->setAccessType('offline');
        $client->setAccessToken($client->getAccessToken());

        $srvce = new Google_Service_Gmail($client);

        $d = $this->listMessages($srvce, "me");

        print_r($d);exit;


        //echo pageHeader("User Query - URL Shortener");
        if (strpos($client_id, "googleusercontent") == false) {
            echo missingClientSecretsWarning();
            exit;
        }
        ?>
        <div class="box">
            <div class="request">
        <?php
        if (isset($authUrl)) {
            echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
        } else {
            echo <<<END
    <form id="url" method="GET" action="{$_SERVER['PHP_SELF']}">
      <input name="url" class="url" type="text">
      <input type="submit" value="Shorten">
    </form>
    <a class='logout' href='?logout'>Logout</a>
END;
        }



        exit("OK");







        $client = new Google_Client();
        $client->setClientId("590108288857-5pupadvvc9h2bbg2nnrtt6mvnjdofvfs.apps.googleusercontent.com");
        $client->setClientSecret("8Y_9AUY2M4zfr9InJFlN-fJf");
        $client->setApplicationName('Web client 2');
        $client->setScopes(array('https://www.googleapis.com/auth/gmail.readonly'));
        $client->setAccessType('offline');

        $access_token = $this->getToken();
                #$client->setAccessToken($access_token);
        #$client->authenticate("4/SQ5co_pwXG2w0_oxUqd-by-hVERx8jAAf0DPBheeBfA");exit;

        #print_r($client->getAccessToken());exit;
        $client->setAccessToken($access_token);


        #$code = $_GET['code'];
        #print_r($code);exit;


        $service = new Google_Service_Gmail($client);
        $userId = 'me';
        $msg_list = $this->listMessages($service, $userId);

        print_r($msg_list);
        exit;
    }



    /*public function listMessages($service, $userId) {
        $pageToken = NULL;
        $messages = array();
        $opt_param = array();
        do {
            try {
                if ($pageToken) {
                    $opt_param['pageToken'] = $pageToken;
                }
                $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
                if ($messagesResponse->getMessages()) {
                    $messages = array_merge($messages, $messagesResponse->getMessages());
                    $pageToken = $messagesResponse->getNextPageToken();
                }
            } catch (Exception $e) {
                print 'An error occurred: ' . $e->getMessage();
            }
        } while ($pageToken);

        foreach ($messages as $message) {
            print 'Message with ID: ' . $message->getId() . '<br/>';
        }

        return $messages;
    }*/




    public function getToken()
    {
        $client = new Google_Client();
        //$client->setAuthConfigFile('apis/client_secret_590108288857.json');
        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
        $client->addScope(SCOPES);
        $client->setAccessType('offline');

        #$key = file_get_contents('apis/my_project_8910357053cf.p12');
        $key = file_get_contents('apis/g-api-0ec6f9f37725.p12');
        $cred = new Google_Auth_AssertionCredentials(
            'account-1@g-api-1131.iam.gserviceaccount.com',
            array('https://www.googleapis.com/auth/gmail.readonly'),
            $key
        );
        $client->setAssertionCredentials($cred);

        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }
        $service_token = $client->getAccessToken();
        return $service_token;
    }


    public function boot_fun(){
        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");

        #if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        if (Session::has('access_token')) {
            $client->setAccessToken(Session::get('access_token') );

            // If access token is not valid use refresh token
            if($client->isAccessTokenExpired()) {
                exit("OK");
                $refresh_token =  $client->getRefreshToken();
                $client->refreshToken($refresh_token);

                Session::put('access_token', $client->getAccessToken());
            }else{
                $client->setAccessToken(Session::get('access_token'));
            }
            print_r(Session::get('code'));
            echo "<br>";
            print_r(Session::get('access_token'));
            echo "<br>";

            // Gmail Service
            $gmail_service = new \Google_Service_Gmail($client);

            // Get List of messages
            $message_data = $this->listMessages($gmail_service, "me");

            print_r($message_data);exit;

            //modify messages by message_id
            foreach($message_data as $values){
                $modify_message = $this->modifyMessages($gmail_service, $values['messageId']);
            }

        } else {
            $authUrl = $client->createAuthUrl();
            #print_r($authUrl);exit;
            #$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun/callback';
            return redirect()->to($authUrl);
        }
    }

    public function boot_fun_callback(){

        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/boot_fun/callback');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");

        if (! isset($_GET['code']))
        {
            $auth_url = $client->createAuthUrl();
            return redirect()->to($auth_url);
        }
        else
        {
            $client->authenticate($_GET['code']);

            Session::put('code', $_GET['code']);
            Session::put('access_token', $client->getAccessToken());

            #$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun';
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/popping-email/store';

            return redirect()->to($redirect_uri);
            #header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }


    function listMessages($service, $userId) {
        $pageToken = NULL;
        $messages = array();
        $opt_param = array();
        do {
            try {
                if ($pageToken) {
                    $opt_param['pageToken'] = $pageToken;
                    #$opt_param['maxResults'] = 100;
                }
                #$opt_param['labelIds'] = 'INBOX';
                #$opt_param['q'] = 'before:'.(string)$before_date.' after:'.(string)$after_date.' subject:"Instant Book Reservation Confirmed" OR subject:"今すぐ予約" OR subject:"Reservation Confirmed" OR subject:"予約が確定しました"';
                #$opt_param = array['labelIds'] = 'Label_143';
                #$opt_param['startHistoryId'] = $historyID;
                #$opt_param['labelId'] = $labelID;
                #$opt_param['fields'] = 'nextPageToken,historyId,history/messagesAdded';
                #$opt_param['q'] = 'in:inbox is:unread -category:(promotions OR social)';
                $opt_param['q'] = 'in:inbox is:unread';

                $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
                $messageList = $messagesResponse->getMessages();
                $inboxMessage = [];

                foreach($messageList as $mlist){
                    $optParamsGet2['format'] = 'full';
                    $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);

                    $message_id = $mlist->id;
                    $headers = $single_message->getPayload()->getHeaders();
                    $snippet = $single_message->getSnippet();

                    foreach($headers as $single) {

                        if ($single->getName() == 'Subject') {
                            $message_subject = $single->getValue();
                        }
                        else if ($single->getName() == 'Date') {
                            $message_date = $single->getValue();
                            $message_date = date('M jS Y h:i A', strtotime($message_date));
                        }
                        else if ($single->getName() == 'From') {
                            $message_sender = $single->getValue();
                            $message_sender = str_replace('"', '', $message_sender);
                        }
                    }
                    $inboxMessage[] = [
                        'messageId' => $message_id,
                        'messageSnippet' => $snippet,
                        'messageSubject' => $message_subject,
                        'messageDate' => $message_date,
                        'messageSender' => $message_sender
                    ];
                }
            } catch (Exception $e) {
                print 'An error occurred: ' . $e->getMessage();
            }
        } while ($pageToken);
        return $inboxMessage;
    }


    /* @
     * @param $gmail_service :: gmail Service
     * @param $message_data_obj :: message data object
     */
    public function modifyMessages($gmail_service, $message_id){
            $labelsToAdd =  ["UNREAD"];
            $labelsToRemove = ["INBOX"];
            $mods = new \Google_Service_Gmail_ModifyMessageRequest();
            $mods->setAddLabelIds($labelsToAdd);
            $mods->setRemoveLabelIds($labelsToRemove);
            try {
                $message = $gmail_service->users_messages->modify("me", $message_id, $mods);
                return true;
            } catch (Exception $e) {
                return false;
            }
    }


    public function tokenInfo(){
        $token_info = new \Google_Service_Oauth2();
        #$token_info->tokeninfo();
        return $token_info->tokeninfo();
    }
    

    public function email_attachment(){

        $body = "Body Message";
        $path = SubMessageAttachment::get();
        try {
                $data_mail = Mail::send('email_template.common', array('body'=>$body), function($message) use ($path){
                    $message->from('devdhaka404@gmail.com' );
                    $message->to('selimppc@gmail.com')->subject('Hello World');
                    $size = sizeOf($path); //get the count of number of attachments

                    for($i=0; $i< $size; $i++){
                        $message->attach($path[$i]->file_name);
                    }
                },true);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }

        exit("END");

    }



    public function test_email_queue_jobs(){

        Mail::queue('email_template.common', array('body'=>"Hello"), function ($message) {
            $message->from('me@selimreza.com', 'SR');
            $message->to('selimppc@gmail.com');
            $message->subject('new subject   000000000');
        });

        exit("OK");

    }



}
