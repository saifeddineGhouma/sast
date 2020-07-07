<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    protected $fillable = [
        'full_name_ar', 'full_name_en', 'date_of_birth', 'username', 'password', 'email', 'government_id', 'gender', 'mobile', 'clothing_size'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_verify()
    {
        return $this->hasOne("App\UserVerify", "user_id");
    }

    public function student()
    {
        return $this->hasOne("App\Student", "id", "id");
    }
    public function teacher()
    {
        return $this->hasOne("App\Teacher", "id", "id");
    }


    public function newsletter_subscibers()
    {
        return $this->hasMany("App\NewsletterSubscriber", "user_id");
    }

    public function government()
    {
        return $this->belongsTo("App\Government", "government_id");
    }

    public function questions()
    {
        return $this->hasMany("App\CourseQuestion", "user_id");
    }

    public function Points()
    {
        return $this->hasMany("App\UserPoint", "user_id");
    }

    public function orders()
    {
        return $this->hasMany("App\Order", "user_id");
    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon', 'coupons_users', 'user_id', 'coupon_id');
    }

    public function user_lang()
    {
        return $this->hasOne("App\UserStudieLang", "user_id");
    }
    public function user_cas_exam()
    {
        return $this->hasMany("App\UserCasExamPratique");
    }
    public function allCoupons()
    {
        $coupon_ids1 = $this->coupons()->pluck("coupons.id")->all();
        $coupon_ids2 = Coupon::doesntHave('coupons_users')->pluck("coupons.id")->all();

        //        $coupon_ids2 = Coupon::join("coupons_shopgroups","coupons_shopgroups.coupon_id","=","coupons.id")
        //            ->join("shopgroups","shopgroups.id","=","coupons_shopgroups.shopgroup_id")
        //            ->join("shopgroups_users","shopgroups.id","=","shopgroups_users.shopgroup_id")
        //            ->where("shopgroups_users.user_id",$this->id)->distinct()->lists("coupons.id")->all();
        $coupons_ids = array_merge($coupon_ids1, $coupon_ids2);
        return Coupon::whereIn("coupons.id", $coupons_ids);
    }


    function getStatus($datafiled, $dataid)
    {
        $span = '';
        $id = '';
        if ($datafiled == 1) {
            $span = '<span class="label label-sm label-success"> active </span>';
            $id = 'on-' . $dataid;
        } else {
            $span = '<span class="label label-sm label-danger"> inactive </span>';
            $id = 'off-' . $dataid;
        }

        return '<a style="cursor: pointer;" class="activeIcon" data-id="' . $id . '"> ' . $span . ' </a>';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function setCounpon($value)
    {
        $coupon = new Coupon();
        $coupon->coupon_number = str_random(5);
        $coupon->discount = $value;
        $coupon->ordertotal_greater = 0.0;
        $coupon->limits = 1;
        $coupon->date_from = '2018-04-05';
        $coupon->date_to = '2018-04-05';
        $coupon->save();

        $usernames = explode(",", $this->username);
        $userIds = User::whereIn("username", $usernames)->pluck("id")->all();
        $coupon->users()->sync($userIds);
        return $coupon->coupon_number;
    }
    public function user_stage()
    {
        return $this->hasMany("App\StudentStage", "user_id");
    }
}
