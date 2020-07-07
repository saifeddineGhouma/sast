<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class AdminHistory extends Model
{
    protected $table="students_history";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'entree',
        'description',
    ];


}
   
