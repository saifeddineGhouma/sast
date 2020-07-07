<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuPos extends Model
{
    protected $table = "menu_pos";
	public $timestamps = false;
	
	public function menus_menupos(){
		return $this->hasMany("App\MenusMenuPos","menupos_id");
	}
	
	public function menus(){
		return $this->belongsToMany("App\Menu","menus_menupos","menupos_id","menu_id");
	}
}
