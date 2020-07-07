<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Clickatell\Api\ClickatellHttp;

class Setting extends Model
{
	protected $table="settings";
	public function settings_trans($lang){
		return $this->hasMany("App\SettingTranslation","setting_id")->where("lang",$lang)->first();
	}
	
	public function socials(){
		return $this->hasMany("App\SettingSocial","setting_id");
	}
	public function sliderimages(){
		return $this->hasMany("App\SettingSliderimage","settings_id");
	}

	public static function clickatell(){
	    return [
            'username'  => 'SwedishAcademy',
            'password' => 'mc#b57g@bcT74',
            'apiID' => '3645017',
        ];
    }

    public static function sendSms($user){
        $username = \App\Setting::clickatell()["username"];
        $password = \App\Setting::clickatell()["password"];
        $apiID = \App\Setting::clickatell()["apiID"];
        $message = "Your Confirmation Code : ".$user->auth_mobile_key;

        $clickatell = new ClickatellHttp($username, $password, $apiID);
        $response = $clickatell->sendMessage(array($user->mobile), $message);
return $response;
//        foreach ($response as $message) {
//            echo $message->id;
//            echo $message->error;
//        }
    }


    public static function humanTiming ($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }
	
}
