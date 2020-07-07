<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class UserCasExamPratique extends Model
{
    protected $table = "user_cas_exam";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cas_exam_pratique_id'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */

    public function cas_exam()
    {
        return $this->belongsTo("App\CasExamPratique");
    }
    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function student()
    {
        return $this->belongsTo("App\Student");
    }
}
