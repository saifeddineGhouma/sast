<?php

namespace App\Http\Controllers\Front;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Course;
use App\UserStudieLang;

use Image;
use Illuminate\Support\Facades\Input;

class StudentStudLangController extends Controller
{
    public function addStudLang($lang_stud, User $user)
    {
        $studLang = new UserStudieLang;
        $studLang->user_id = $user->id;
        $studLang->lang_stud = $lang_stud;

        $studLang->save();
        return redirect()->back();
    }
}
// /test.swedish-academy.se/uploads/kcfinder/upload/image/stage
// '/uploads/kcfinder/upload/image/stage/'
