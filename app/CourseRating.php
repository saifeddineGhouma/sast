<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    protected $table="course_rating";
	 
	public function course(){
		return $this->belongsTo("App\Course","course_id");
	}
	 
	public function user(){
		return $this->belongsTo("App\User","user_id");
	}
	
	function getStatus($datafiled,$dataid){
		$span = '';
		$id = '';
		if ($datafiled==1) {
			$span = '<span class="label label-sm label-success"> approved </span>';
			$id = 'on-'.$dataid;
		} else {
			$span = '<span class="label label-sm label-danger"> not approved </span>';
			$id = 'off-'.$dataid;
		}
		
		return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a>';
	}
}
