<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SenderEmail extends Model
{
    protected $table = 'sender_email';

    protected $fillable = [
        'campaign_id',
        'name',
        'email',
        'password',
        'smtp_id',
        'imap_id',
        'popping_status',
        'status',
        'type',
        'count',
        'count_per_min_pm',
        'max_email_send',
        'auth_token',
        'auth_code',
        'api_type',
        'auth_id',
        'auth_email',
        'auth_avatar'
    ];

    //Model Relationship for Campaign
    public function relCampaign(){
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function relPoppedMessageHeader(){
        return $this->HasMany('App\PoppedMessageHeader', 'sender_email_id');
    }

    //Model Relationship for Smtp
    public function relSmtp(){
        return $this->belongsTo('App\Smtp', 'smtp_id', 'id');
    }

    //Model Relationship for Imap
    public function relImap(){
        return $this->belongsTo('App\Imap', 'imap_id', 'id');
    }




    // TODO : user info while saving data into table
    /*public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::user()->check()){
                $query->created_by = Auth::user()->get()->id;
            }
        });
        static::updating(function($query){
            if(Auth::user()->check()){
                $query->updated_by = Auth::user()->get()->id;
            }
        });
    }*/


    // TODO : Scope Area
    /**
     * @param $query
     * @param $campaign_id
     * @return boolean
     */
    public function scopeGetSenderEmailByCampaign($query , $campaign_id){
        $exists = SenderEmail::where('campaign_id', $campaign_id)->exists();
        if($exists){
            $query = SenderEmail::join('smtp', function($join)
            {
                $join->on('sender_email.smtp_id', '=', 'smtp.id');
            })
                ->where('sender_email.campaign_id', '=', $campaign_id)
                #->where('sender_email.popping_status', '=', 'true')
                ->orderBy('sender_email.count', 'asc')
                ->select(DB::raw('sender_email.id,sender_email.name, sender_email.email,sender_email.password, smtp.server_username, smtp.server_password, smtp.host, smtp.port, smtp.mails_per_day_per_email'))
                ->first();
            return $query;
        }

    }




    /**
     * @param $query
     * @param $sender_email_id
     * @return boolean
     */
    public function scopeUpdateSenderEmailById($query , $sender_email_id){
        //$query = DB::table('sender_email')->increment('count', 1, ['id' => $sender_email_id]);
        $query = DB::table('sender_email')->where('id','=',$sender_email_id)->increment('count', 1);
        return $query;
    }

    /**
     * @param $email_id : can be email address or domain
     * @return mixed : type will be non-generated or generated
     */
    public function scopeEmailTypeIdentification($query, $email_id, $type_or_status){

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
