<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{

    protected $table = 'smtp';

    protected $fillable = [
        'name',
        'server_username',
        'server_password',
        'host',
        'port',
        'auth',
        'secure',
        'mails_per_day_per_email',
        'type',
        'smtp',
        'c_port'
    ];


    public static function known_smtp_list(){
        $data = PublicDomain::get()->lists('title','id');
        $ksl = [];
        $i = 0;
        foreach($data as $d){
            $ksl[$i++] = $d;
        }
        return $ksl;
    }

}
