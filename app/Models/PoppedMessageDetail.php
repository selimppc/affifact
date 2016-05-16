<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoppedMessageDetail extends Model
{
    protected $table = 'popped_message_detail';

    protected $fillable=[
        'popped_message_header_id',
        'sub_message_id',
        'followup_sub_message_id',
        'sent_time',
        'd_status',
        'user_message_body',
        'custom_message',
        'sender_email',
    ];
}
