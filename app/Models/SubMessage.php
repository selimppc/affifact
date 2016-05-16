<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMessage extends Model
{
    protected $table = 'sub_message';
    protected $fillable = [
        'message_id','title','description','order','start_time','end_time'
    ];

    //relation one to many with message-----------------------------------
    public function relMessage()
    {
        return $this->belongsTo('App\Message', 'message_id', 'id');
    }

    public function relSubMessageAttachment()
    {
        return $this->HasMany('App\SubMessageAttachment', 'sub_message_id');
    }
}
