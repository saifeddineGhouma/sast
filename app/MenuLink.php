<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    protected $table = "menu_links";
	public $timestamps = false;
	
	public function menulink_trans($lang){
		return $this->hasMany("App\MenuLinkTranslation","menulink_id")->where("lang",$lang)->first();
	}
	
	public function childs(){
		return $this->hasMany("App\MenuLink","parent_id","id");
	}
}
