<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 12/14/15
 * Time: 10:15 AM
 */

namespace App\Helpers;


class VerifyEmail
{

    /*@
     * $to_email == verify email
     * $from_email == any email
     * $get_details == result mixed
     *
    */
    public static function verify_email($to_email, $from_email, $get_details = false){
        $email_arr = explode("@", $to_email);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];

        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");

        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }

        $mxhosts = array();
        $details = '';
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);

        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }

            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {

                $result   = "invalid";
                $details .= "No suitable MX records found.";

                return ( (true == $get_details) ? array($result, $details) : $result );
            }
        }

        $connect = @fsockopen($mx_ip, 25);
        if($connect){
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n");
                $out = fgets ($connect, 1024);
                $details .= $out."\n";

                fputs ($connect , "MAIL FROM: <$from_email>\r\n");
                $from = fgets ($connect, 1024);
                $details .= $from."\n";

                fputs ($connect , "RCPT TO: <$to_email>\r\n");
                $to = fgets ($connect, 1024);
                $details .= $to."\n";

                fputs ($connect , "QUIT");
                fclose($connect);

                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid";
                }
                else{
                    $result = "valid";
                }
            }
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($get_details){
            return array($result, $details);
        }
        else{
            return $result;
        }
    }


}