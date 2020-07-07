<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class UserVerify extends Model
{
    protected $table = "users_verify";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'url_certif', 'serial_number', 'verify'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function student()
    {
        return $this->belongsTo("App\Student");
    }
    public function course()
    {
        return $this->belongsTo("App\Course");
    }
}
