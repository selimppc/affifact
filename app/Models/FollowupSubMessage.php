<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 9/22/15
 * Time: 2:09 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupSubMessage extends Model
{

    protected $table = 'followup_sub_message';

    protected $fillable = [
        'followup_message_id','title','description','order','start_time','end_time'
    ];

    //TODO : Model Relationship
    public function relMessageFollowup(){
        return $this->belongsTo('App\FollowupMessage', 'followup_message_id', 'id');
    }

    public function relFollowupSubMessageAttachment()
    {
        return $this->HasMany('App\FollowupSubMessageAttachment', 'followup_sub_message_id');
    }
}