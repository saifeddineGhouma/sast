<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseView extends Model
{
     protected $table="course_views";
	 
	 public function course(){
		return $this->belongsTo("App\Course");
	}
}
