<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
   protected $table = "logs";
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
    ];

}
   
