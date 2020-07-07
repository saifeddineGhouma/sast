<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class AdminHistory extends Model
{
    protected $table="admin_history";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'entree',
        'sortie',
        'description',
    ];


}
   
