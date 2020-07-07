<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\TeacherResetPasswordNotification;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class TeacherUser extends Authenticatable
{
    use Notifiable,EntrustUserTrait;
    protected $guard="teachers";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="users";
    protected $fillable = [
        'full_name_ar','full_name_en','date_of_birth','username','password', 'email','government','gender', 'mobile','clothing_size'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
			
	public function student(){
		return $this->hasOne("App\Student","id","id");
	}

    public function teacher(){
        return $this->hasOne("App\Teacher","id","id");
    }
	

    public function questions(){
	    return $this->hasMany("App\CourseQuestion","user_id");
    }

    public function Points(){
        return $this->hasMany("App\UserPoint","user_id");
    }

    public function orders(){
        return $this->hasMany("App\Order","user_id");
    }

    public function coupons(){
        return $this->belongsToMany('App\Coupon','coupons_users','user_id','coupon_id');
    }

    public function allCoupons(){
        $coupon_ids1 = $this->coupons()->pluck("coupons.id")->all();
        $coupon_ids2 = Coupon::doesntHave('coupons_users')->pluck("coupons.id")->all();

//        $coupon_ids2 = Coupon::join("coupons_shopgroups","coupons_shopgroups.coupon_id","=","coupons.id")
//            ->join("shopgroups","shopgroups.id","=","coupons_shopgroups.shopgroup_id")
//            ->join("shopgroups_users","shopgroups.id","=","shopgroups_users.shopgroup_id")
//            ->where("shopgroups_users.user_id",$this->id)->distinct()->lists("coupons.id")->all();
        $coupons_ids = array_merge($coupon_ids1, $coupon_ids2);
        return Coupon::whereIn("coupons.id",$coupons_ids);
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TeacherResetPasswordNotification($token));
    }
}
