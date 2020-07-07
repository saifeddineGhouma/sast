<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
   protected $table = "news";
   
   public function news_trans($lang){
		return $this->hasMany("App\NewsTranslation","news_id")->where("lang",$lang)->first();
	}
   
    public function publisher(){
		return $this->belongsTo('App\Admin','publisher_id');
	}
	
	public function views(){
		return $this->hasMany("App\NewsView","news_id");
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
   
