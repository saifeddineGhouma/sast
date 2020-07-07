<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

	public function coupons_users(){
		return $this->hasMany('App\CouponUser','coupon_id');
	}
	public function users(){
		return $this->belongsToMany('App\User','coupons_users','coupon_id','user_id');
	}

}
