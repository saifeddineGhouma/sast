<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
   protected $table = "governments";
   public function country(){
		return $this->belongsTo('App\Country','country_id');
	}
   
    public function government_trans($lang){
		return $this->hasMany("App\GovernmentTranslation","government_id")->where("lang",$lang)->first();
	}
	
}
