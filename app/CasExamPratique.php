<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class CasExamPratique extends Model
{

    protected $table = "cas_exam_pratique";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */

    public function user_cas()
    {
        return $this->hasMany("App\UserCasExamPratique", "cas_exam_pratique_id");
    }
}
