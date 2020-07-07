<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    protected $table = "countries";
	public function country_trans($lang){
		return $this->hasMany("App\CountryTranslation","country_id")->where("lang",$lang)->first();
	}
	public function governments(){
		return $this->hasMany("App\Government","country_id");
	}
    public function agents(){
        return $this->hasMany("App\Agent","country_id");
    }
}
