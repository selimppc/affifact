<?php
/**
 * Created by PhpStorm.
 * User: selimets
 * Date: 11/8/15
 * Time: 11:12 AM
 */

namespace App\Helpers;

use App\SenderEmail;
use DB;
use App\Helpers\Xmlapi;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
#use Mockery\CountValidator\Exception;
use Exception;
use App\Smtp;


class SenderEmailCheck
{
    public static function sender_email_checking($id = null)
    {

        if($id){
            $sender_email = SenderEmail::with('relImap')->where('id', '=', $id)->get();

        }else{

            $sender_email = SenderEmail::with('relImap')->where('status', '!=', 'invalid')->get();

        }


        foreach($sender_email as $value) {
            if ($value->api_type != 'google') {
                $hostname = '{' . $value->relImap->host . ':993/imap/ssl/novalidate-cert}INBOX';
                $username = $value->email;
                $password = $value->password;

                $inbox = @imap_open($hostname, $username, $password);

                if (imap_errors()) {
                    DB::table('sender_email')->where('id', $value->id)->update(['status' => 'invalid', 'updated_at' => date("Y-m-d H:i:s")]);
                    $result = false;
                    print "Invalid : " . $value->id . "\n";
                } else {
                    DB::table('sender_email')->where('id', $value->id)->update(['updated_at' => date("Y-m-d H:i:s")]);
                    $result = true;
                    print "Valid : " . $value->id . "\n";
                }

            } else {
                DB::table('sender_email')->where('id', @$sender_email['id'])->update(['status' => 'valid', 'updated_at' => date("Y-m-d H:i:s")]);
                $result = true;
                print "Valid : " . @$sender_email['id'] . "\n";
            }

        }
        // if a single email is checked then it needs to return true or false.
        if($id)
            return @$result;
    }
    public static function sender_email_checking_byEmail($email = null)
    {

        if ($email) {
            $sender_email = SenderEmail::with('relImap')->where('email', '=', $email)->where('api_type', '!=', 'google')->get();
        } else {
            $sender_email = SenderEmail::with('relImap')->where('status', '!=', 'invalid')->where('api_type', '!=', 'google')->get();
        }
        if (count($sender_email)<= 0) {
            $result = '';
            $result = false;
        } else {

            foreach ($sender_email as $value) {
                $hostname = '{' . $value->relImap->host . ':993/imap/ssl/novalidate-cert}INBOX';
                $username = $value->email;
                $password = $value->password;

                $inbox = @imap_open($hostname, $username, $password);
                if (imap_errors()) {
                    DB::table('sender_email')->where('id', $value->id)->update(['status' => 'invalid']);
                    $result = false;
                } else {
                    $result = true;
                }
            }

            // if a single email is checked then it needs to return true or false.
            if ($email)
                return $result;
        }
    }

    /**
     * Get Sender email according to count < mails_per_day_per_email
     * @param $camp_id
     * @param null $exclude_se  :: $exclude_se is added to eclude the current Sender email from the query
     * @return mixed
     */
    public static function get_sender_email_public($camp_id, $exclude_se = null){

        if($exclude_se) {
            $se_email = SenderEmail::with(['relSmtp' => function ($query) {
                $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
            }])
                ->where('campaign_id', $camp_id)
                ->where('status', 'public')
                ->whereRaw('id !=' . $exclude_se)
                ->orderBy('count', 'asc')
                ->orderByRaw("RAND()")
                ->first();
        }else{
            $se_email = SenderEmail::with(['relSmtp' => function ($query) {
                $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
            }])
                ->where('campaign_id', $camp_id)
                ->where('status', 'public')
                ->orderBy('count', 'asc')
                ->orderByRaw("RAND()")
                ->first();
        }

        return $se_email;
    }

    /**
     * Get Sender email according to count < mails_per_day_per_email
     * @param $camp_id
     * @param null $exclude_se  // $exclude_se is added to eclude the current Sender email from the query
     * @return mixed
     */
    public static function get_sender_email_domain($camp_id, $exclude_se = null){
        if($exclude_se){
            $se_email = SenderEmail::with(['relSmtp' => function ($query) {
                $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
            }])
                ->where('campaign_id', $camp_id)
                ->where('status', 'domain')
                ->whereRaw('id !=' . $exclude_se)
                ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
                ->orderBy('count', 'ASC')
                ->orderByRaw("RAND()")
                ->first();
        }else {
            $se_email = SenderEmail::with(['relSmtp' => function ($query) {
                $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
            }])
                ->where('campaign_id', $camp_id)
                ->where('status', 'domain')
                ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
                ->orderBy('count', 'ASC')
                ->orderByRaw("RAND()")
                ->first();
        }
        return $se_email;
    }

    public static function EmailTypeIdentification($email_id, $type_or_status){

        if($fs = strpos($email_id, '@')){
            $dm = explode('@', $email_id);
            $domain = $dm[1];
        }else{
            $domain = $email_id;
        }

        $public_domain_list = Smtp::known_smtp_list();
        $tp = array_filter($public_domain_list, function($el) use ($domain) {
            return ( strpos($el, $domain) !== false );
        });

        if(count($tp) > 0) {
            if($type_or_status == 'type')
                $ret_text = 'not-generated';
            else{
                $dn = explode('.',$domain);
                $ret_text = $dn[0];
            }

        }else {
            if($type_or_status == 'type')
                $ret_text = 'generated';
            else
                $ret_text = 'domain';
        }
        return $ret_text;
    }
}