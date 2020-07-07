<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
   protected $table = "faq";
   
   public function faq_trans($lang){
		return $this->hasMany("App\FaqTranslation","faq_id")->where("lang",$lang)->first();
	}
}
   
