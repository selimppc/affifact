<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;

class Campaign extends Model
{
    protected $table = 'campaign';

    protected $fillable = [
        'name','popping_email_id','status'
    ];



    public function relPoppingEmail(){
        return $this->belongsTo('App\PoppingEmail', 'popping_email_id', 'id');
    }

    public function relMessage(){
        return $this->HasMany('App\Message', 'campaign_id');
    }

    public function relSenderEmail(){
        return $this->HasMany('App\SenderEmail', 'campaign_id');
    }
}
