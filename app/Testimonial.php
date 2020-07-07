<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
   protected $table = "testimonials";
   public function testimonial_trans($lang){
		return $this->hasMany("App\TestimonialTranslation","testimonial_id")->where("lang",$lang)->first();
	}
      
      
   function getStatus($datafiled,$dataid){
		$span = '';
		$id = '';
		if ($datafiled==1) {
			$span = '<span class="label label-sm label-success"> active </span>';
			$id = 'on-'.$dataid;
		} else {
			$span = '<span class="label label-sm label-danger"> inactive </span>';
			$id = 'off-'.$dataid;
		}
		
		return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a>';
	}
}
   
