<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 4/5/16
 * Time: 5:07 PM
 */

namespace app\Helpers;

use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Laravel\Socialite\Facades\Socialite;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;
use Illuminate\Support\Facades\DB;
use App\SenderEmail;
use App\PoppedMessageDetail;

class GmailSendMessage
{
    /**
     * Send Message.
     *
     * @param  Google_Service_Gmail $service Authorized Gmail API instance.
     * @param  string $userId User's email address. The special value 'me'
     * can be used to indicate the authenticated user.
     * @param  Google_Service_Gmail_Message $message Message to send.
     * @return Google_Service_Gmail_Message sent Message.
     *
     * @param $host
     * @param $port
     * @param $from_email
     * @param $from_name
     * @param $username
     * @param $password
     * @param $to_email
     * @param $subject
     * @param $body
     * @param $file_name
     * @param $reply_to
     * @param null $reply_to_name
     * @param null $camp_id
     * @param null $popped_message_detail_id
     * @return bool|string
     */

    public static function sendMessage($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id=null, $auth_token, $auth_code=null, $popped_message_detail_id = null) {

        print "Host : ".$host."\n";
        print "Port : ".$port."\n";
        print "from email : ".$from_email."\n";
        print "from name : ".$from_name."\n";
        print "username : ".$username."\n";
        print "password : ".$password."\n";
        print "to email : ".$to_email."\n";
        print "subject : ".$subject."\n";
        print "body : ".$body."\n";
        #$file_name;
        print "reply to : ".$reply_to."\n";
        print "reply to Name : ".$reply_to_name."\n";
        print "auth_token : ".$auth_token."\n";
        print "auth_code : ".$auth_code."\n";
        #exit;


        // before firing email check the limit of sending for sender email
        $se_limit_check = GmailSendMessage::limit_check_for_sender_email($from_email, $campaign_id);


        if($se_limit_check != null){
            $from_email = $se_limit_check;

            //run the code
            if ($auth_token) {

                // Gmail API
                //Google client
                $client = new Google_Client();
                $client->setAuthConfigFile(public_path() . '/apis/api_for_sender_email.json');
                $client->setLoginHint($from_email);
                $client->setAccessType('offline');
                $json_token = $auth_token;

                try {
                    $client->setAccessToken($json_token);
                    // If access token is not valid use refresh token
                    if ($client->isAccessTokenExpired()) {
                        $refresh_token = $client->getRefreshToken();
                        $client->refreshToken($refresh_token);
                    }

                    // Gmail Service
                    $gmail_service = new \Google_Service_Gmail($client);
                    $userID = 'me';

                    //prepare the mail with PHPMailer
                    $mail = new \PHPMailer();
                    $mail->CharSet = "UTF-8";
                    $mail->Encoding = "base64";

                    //supply with your header info, body etc...

                    //TODO::Enable SMTP debugging.
                    $mail->SMTPDebug = 3;
                    $mail->isSMTP();
                    $mail->Host = $host; // "smtp.gmail.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = $username; //"devdhaka405@gmail.com";
                    $mail->Password = $password; //"etsb1234";
                    $mail->SMTPSecure = "ssl"; // "tls";
                    $mail->Port = $port; //587;

                    //From email address and name
                    $mail->From = $from_email; //"selimppc@gmail.com";
                    $mail->FromName = $from_name; //"Selim Reza";

                    //TODO::To address and name
                    #$mail->addAddress("devdhaka405@gmail.com", "Dev Dhaka 405");
                    #$mail->addAddress("tanintjt@gmail.com", "Tanvir Jahan"); //Recipient name is optional
                    $mail->addAddress($to_email, $to_email); //Recipient name is optional

                    //TODO::Address to which recipient will reply
                    $mail->addReplyTo($reply_to, $reply_to_name);

                    //TODO::CC and BCC
                    #$mail->addCC("selimppc@gmail.com");
                    #$mail->addBCC("shajjadhossain81@gmail.com");

                    //TODO::Provide file path and name of the attachments
                    #$mail->addAttachment("file.txt", "File.txt");
                    #$mail->addAttachment("images/profile.png"); //Filename is optional

                    //TODO:: configure attachment in laravel
                    if (count($file_name) > 0) {
                        $size = sizeOf($file_name); //get the count of number of attachments
                        for ($i = 0; $i < $size; $i++) {
                            $mail->addAttachment($file_name[$i]);
                        }
                    }

                    //Send HTML or Plain Text email
                    $mail->isHTML(true);

                    $mail->Subject = $subject;
                    $mail->Body = $body; //"<i>Ho ho .. please ignore this one for your safety </i>";
                    $mail->AltBody = $body;


                    //create the MIME Message
                    $mail->preSend();
                    $mime = $mail->getSentMIMEMessage();
                    $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');

                    //create the Gmail Message
                    $message = new \Google_Service_Gmail_Message();
                    $message->setRaw($mime);
                    $message = $gmail_service->users_messages->send($userID, $message);

                    //update sender email count
                    if ($campaign_id)
                        $model = SenderEmail::where('email', $from_email)->where('campaign_id', $campaign_id)->first();
                    else
                        $model = SenderEmail::where('email', $from_email)->first();

                    $model->count = $model->count + 1;
                    $model->save();

                    if($popped_message_detail_id){

                        //Pooped Message Detail UPDATE
                        $pmd = PoppedMessageDetail::findOrFail($popped_message_detail_id);
                        $pmd->sender_email = $from_email;
                        $pmd->d_status = 'mail-sent';
                        $pmd->save();
                    }

                    return true;

                    #return $from_email;
                } catch (\Exception $e) {
                    /*DB::table('sender_email')
                        ->where('email', $from_email)
                        ->update(['status' => 'domain']);*/
                    return false;
                }
            }
        }else{
            return false;
        }

    }


    //check email validity
    public static function check_valid_gmail($from_email = null, $auth_token = null){
        $selected_se = null;
        if($from_email && $auth_token ) {
            $result = GmailSendMessage::re_check_gmail_authentication($auth_token);
            if ($result == 'valid') {
                $selected_se =  ['status' => 'valid_existing',
                    'email' => $from_email,
                    'auth_token' => $auth_token
                ];
            }else{
                $sender_email = SenderEmail::where('email', $from_email)->first();
                $sender_email->status = 'invalid';
                $sender_email->save();
                /*
                $selected_se =  ['status' => 'invalid',
                    'email' => $from_email,
                    'auth_token' => $auth_token
                ];*/
                $se_email = SenderEmail::where('api_type', 'google')
                    ->where('status', 'public')
                    ->where('count', '<', 'max_email_send')
                    ->get();
                foreach ($se_email as $se) {
                    $result = GmailSendMessage::re_check_gmail_authentication($se->auth_token);
                    if ($result == 'valid') {
                        $selected_se =  ['status' => 'valid',
                            'email' => $se->email,
                            'auth_token' => $se->auth_token,
                            'sender_email_id' => $se->id
                        ];
                        break;
                    }
                }
            }
        }/*else {

        }*/

        return  $selected_se;

    }

    /*
     * @param $from_email
     * @param $auth_token
     */
    public static function re_check_gmail_authentication( $auth_token){
        // Gmail API
        //Google client
        $client = new Google_Client();
        $client->setAuthConfigFile(public_path() . '/apis/api_for_sender_email.json');
        #$client->setLoginHint($from_email);
        $client->setAccessType('offline');
        $json_token = $auth_token;

        try {
            $client->setAccessToken($json_token);
            // If access token is not valid use refresh token
            if ($client->isAccessTokenExpired()) {
                $refresh_token = $client->getRefreshToken();
                $client->refreshToken($refresh_token);
            }
            return 'valid';
        } catch (\Exception $e) {
            return $e->getCode();
        }

    }

    /*
     * @param $from_email
     */

    public static function limit_check_for_sender_email($from_email, $camp_id=null)
    {

        if($from_email){

            //check if campaign id
            if($camp_id){
                $sender_email = SenderEmail::where('email', $from_email)
                    ->where('campaign_id', $camp_id)
                    ->whereRaw('count < max_email_send')
                    ->first();
            }else{
                $sender_email = SenderEmail::where('email', $from_email)
                    ->whereRaw('count < max_email_send')
                    ->first();
            }

            //Sender Email check with domain type
            if($sender_email){
                //$from_email = $from_email;
            }else{
                $sender_email_stat = SenderEmail::where('email', $from_email)->first();
                //domain type for sender email
                $domain_type = $sender_email_stat->status;

                if($camp_id){
                    $se = SenderEmail::where('status', $domain_type)
                        ->where('campaign_id', $camp_id)
                        ->whereRaw('count < max_email_send')
                        ->orderByRaw("RAND()")
                        ->first();
                }else{
                    $se = SenderEmail::where('status', $domain_type)
                        ->whereRaw('count < max_email_send')
                        ->orderByRaw("RAND()")
                        ->first();
                }

                if($se){
                    $from_email = $se->email;
                }else{
                    $from_email = null;
                }
            }
        }else{
            $from_email = null;
        }

        return $from_email;
    }




}