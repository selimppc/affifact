<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupMessage extends Model
{
    protected $table = 'followup_message';

    protected $fillable = [
        'campaign_id','html','delay','description','order'
    ];

    //TODO : Model Relationship
    public function relCampaign(){
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function relFollowupSubMessage(){
        return $this->HasMany('App\FollowupSubMessage', 'followup_message_id');
    }
}
