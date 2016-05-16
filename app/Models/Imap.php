<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imap extends Model
{
    protected $table = 'imap';
    protected $fillable = [
        'name',
        'host',
        'port',
        'charset',
        'secure'
    ];


    public static function host_list(){
        return [
            'ymail.com',
            'yahoo.com',
            'gmail.com',
            'google.com',
            'msn.com',
            'facebook.com',
        ];
    }
}
