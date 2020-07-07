<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    public function page_trans($lang){
		return $this->hasMany("App\PageTranslation","page_id")->where("lang",$lang)->first();
	}
	
    function getStatus($datafiled,$dataid,$filed){
		$imageUrl = 'assets/admin/img/';
		$id = '';
		if ($datafiled==1) {
			$imageUrl .= 'true.png';
			$id = 'on-'.$dataid;
		} else {
			$imageUrl .= 'false.png';
			$id = 'off-'.$dataid;
		}
		if($filed=="in_home"){
			return '<a style="cursor: pointer;" class="in_homeIcon"> <img src = "'.asset($imageUrl).'" width = "30" class = "'.$id.'" id = "h'.$id.'" ></a>' ;
			
		}else if($filed=="in_footer"){
			return '<a style="cursor: pointer;" class="in_footerIcon"> <img src = "'.asset($imageUrl).'" width = "30" class = "'.$id.'" id = "f'.$id.'" ></a>' ;
			
		}{
			return '<a style="cursor: pointer;" class="activeIcon"> <img src = "'.asset($imageUrl).'" width = "30" class = "'.$id.'" id = "'.$id.'" ></a>';
		}
	}
}
