<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStudy extends Model
{
    protected $table="course_studies";

    public function course(){
        return $this->belongsTo("App\Course");
    }
}
   
