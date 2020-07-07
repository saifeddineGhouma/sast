<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentStage extends Model
{
    protected $table = "students_stage";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'user_id',
        'demande_stage',
        'evaluation_stage',
        'valider'
    ];
    public function course()
    {
        return $this->belongsTo("App\Course");
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
