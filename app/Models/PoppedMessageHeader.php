<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoppedMessageHeader extends Model
{
    protected $table = 'popped_message_header';

    protected $fillable = [
        'campaign_id',
        'user_email',
        'user_name',
        'subject',
        'message_order',
        'followup_message_order',
        'status',
        #'sender_email',
        'sender_email_id',
    ];


    /// TOdo :: Relationship

    public function relCampaign(){
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }


    public function relFollowupMessage(){
        return $this->belongsTo('App\FollowupMessage', 'campaign_id', 'id');
    }


    public function relPoppedMessageDetail(){
        return $this->HasMany('App\PoppedMessageDetail');
    }

    public function relSenderEmail(){
        return $this->belongsTo('App\SenderEmail', 'sender_email_id', 'id');
    }


}
