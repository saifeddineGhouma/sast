<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
     protected $table="courses_categories";
	 public $timestamps = false;

	 public function course(){
		return $this->belongsTo("App\Course");
	}
}
