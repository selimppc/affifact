<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoppingEmail extends Model
{
    protected $table = 'popping_email';

    protected $fillable = [
        'name','email','password','smtp_id','imap_id','token','auth_id','auth_email','auth_avatar','auth_type', 'code'
    ];


    //TODO : Model Relationship for Smtp
    public function relSmtp(){
        return $this->belongsTo('App\Smtp', 'smtp_id', 'id');
    }

    //TODO : Model Relationship for Imap
    public function relImap(){
        return $this->belongsTo('App\Imap', 'imap_id', 'id');
    }


    public function relCampaign(){
        return $this->belongsTo('App\Campaign', 'id', 'imap_id');
    }

    public function relCampaign_name(){
        return $this->belongsTo('App\Campaign', 'id', 'popping_email_id');
    }
}
