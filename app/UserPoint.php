<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
	protected $table = "user_points";
	
	public function orderproduct(){
		return $this->belongsTo("App\OrderProduct","orderproduct_id");
	}
}
