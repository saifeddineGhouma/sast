<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
   protected $table = "newsletter";
   
	function getStatus($datafiled,$dataid){
		$span = '';
		$id = '';
		if ($datafiled==1) {
			$span = '<span class="label label-sm label-success"> active </span>';
			$id = 'on-'.$dataid;
		} else {
			$span = '<span class="label label-sm label-danger"> not active </span>';
			$id = 'off-'.$dataid;
		}
		
		return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a>';
	}
}
