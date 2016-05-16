<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMessageAttachment extends Model
{
    protected $table = 'sub_message_attachment';
    protected $fillable = [
        'sub_message_id',
        'file_name',
        'file_type',
        'file_size',
    ];
    public function relSubMessage()
    {
        return $this->belongsTo('App\SubMessage', 'sub_message_id', 'id');
    }
}
