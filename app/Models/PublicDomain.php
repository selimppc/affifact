<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 11/8/15
 * Time: 3:29 PM
 */

namespace App;

use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;

class PublicDomain extends Model
{
    protected $table = 'public_domain';

    protected $fillable = [
        'title','domain_name','status'
    ];

    /*public static function public_domain_list(){

        $data = PublicDomain::get()->lists('title','id');
//        print_r($data);exit;
        return $data;
    }*/
}