<?php

namespace App\Http\Controllers\Front;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Course;
use App\UserStudieLang;
use Auth ;
use Image;
use Illuminate\Support\Facades\Input;

class StudentStudLangController extends Controller
{
    public function addStudLang($lang_stud, $user)
    {
        $langexist= UserStudieLang::where('user_id',$user)->first();
        if($langexist)
        {
            $langexist->lang_stud = $lang_stud;
            $langexist->save();

        }else{
              $studLang = new UserStudieLang;
        $studLang->user_id =$user;
        $studLang->lang_stud = $lang_stud;
        $studLang->save();
        }
        return redirect()->back();
    }
	public function addStudLangNew(Request $request)
        {
        

    }
}
// /test.swedish-academy.se/uploads/kcfinder/upload/image/stage
// '/uploads/kcfinder/upload/image/stage/'
