<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crud extends Model
{

    protected $table = 'crud';

    protected $fillable = [
        'name'
    ];


    /*public function boot()
    {
        $this::creating(function ($user) {
            if ( ! $user->isValid()) {
                return false;
            }
        });
    }*/


    /**
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Scope a query to only include popular users.
     */
    public function scopePopular($query)
    {
        return $query->where('name', '=', 'Selim');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('name', 1);
    }



}
