<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseDiscount extends Model
{
    protected $table="course_discounts";
    public $timestamps = false;

    public function course(){
        return $this->belongsTo("App\Course");
    }
}
   
