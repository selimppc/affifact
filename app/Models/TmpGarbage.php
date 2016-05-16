<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpGarbage extends Model
{
    protected $table = 'tmp_garbage';

    protected $fillablee = [
        'host',
        'port',
        'campaign_id',
        'sender_email_id',
        'from_email',
        'from_name',
        'username',
        'password',
        'to_email',
        'subject',
        'body',
        'file_name',
        'reply_to'
    ];

    // TOdo :: Relationship


}
