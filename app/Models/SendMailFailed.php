<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Http\Request;

class SendMailFailed extends Model
{
    protected $table = 'send_mail_failed';

    protected $fillable = [
        'host',
        'port',
        'campaign_id',
        'sender_email_id',
        'from_email',
        'from_name',
        'username',
        'password',
        'to_email',
        'popped_message_header_id',
        'popped_message_detail_id',
        'subject',
        'body',
        'file_name',
        'reply_to',
        'start_time',
        'end_time',
        'no_of_try',
        'msg'
    ];

    public function relCampaign(){
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
