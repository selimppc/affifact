<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupSubMessageAttachment extends Model
{
    protected $table = 'followup_sub_message_attachment';
    protected $fillable = [
        'followup_sub_message_id',
        'file_name',
        'file_type',
        'file_size',
    ];
    public function relFollowupSubMessage()
    {
        return $this->belongsTo('App\FollowupSubMessage', 'sub_message_id', 'id');
    }
}
