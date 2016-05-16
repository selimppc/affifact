<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    protected $table = 'email_queue';

    protected $fillable = [
        'popped_message_header_id',
        'sub_message_id',
        'followup_message_id',
        'send_time',
        'sender_email_id',
        'to_email'
    ];



    // TOdo :: Relationship

    public function relSenderEmail(){
        return $this->belongsTo('App\SenderEmail', 'sender_email_id', 'id');
    }
}
