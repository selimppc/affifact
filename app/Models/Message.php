<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $fillable = [
        'campaign_id','html','delay','order'
    ];


    public function relCampaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function relSubMessage(){
        return $this->HasMany('App\SubMessage', 'message_id');
    }
}

