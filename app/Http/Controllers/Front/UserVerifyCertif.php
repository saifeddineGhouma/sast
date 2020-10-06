<?php

namespace App\Http\Controllers\Front;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Course;
use App\UserVerify;
use App\StudentCertificate;
use App\Admin;
use App\Notifications\VerifyFile;
use Notification;

use Image;
use Illuminate\Support\Facades\Input;

class UserVerifyCertif extends Controller
{
    public function addVerify(Request $request, User $user, Course $course)
    {
        $studentCertifUsers = StudentCertificate::where("student_id", "=", $user->id)->get();

        $studentCertif = $studentCertifUsers->where("serialnumber", "=", $request->serial_number)->count();


        if (isset($request->serial_number)) {
            if ($studentCertif > 0) {
                $userVerify = new UserVerify;
                $userVerify->serial_number = $request->serial_number;
                $userVerify->user_id = $user->id;
                $userVerify->course_id = $course->id;
                $userVerify->verify = 1;
                $userVerify->save();
                return redirect()->back();
            } else {
                return redirect()->back()->withErrors(['الرجاء التثبت من الرقم التسلسلي']);
              
            }
        } else {
            $userVerify = new UserVerify;
            // $userVerify->serial_number = $request->serial_number; 
            $userVerify->user_id = $user->id;
            $userVerify->course_id = $course->id;

            $file = $request->url_certif;
            if ($request->has('url_certif')) {
                $name = time() . '_' . $file->getClientOriginalName();
                $path = 'uploads/kcfinder/upload/image/verifyCertif';
                //  Image::make($file->getRealPath())->save($path);
                Input::file('url_certif')->move($path, $name);
                $userVerify->url_certif = $name;
            }



            //file evaluation stage 
            $userVerify->verify = 0;

            $userVerify->save();
            // $user = Auth::user();
            $admins = \App\Admin::get();
            Notification::send($admins, new VerifyFile($userVerify->course_id, $user->username));


            return redirect()->back();
        }
    }
}
// /test.swedish-academy.se/uploads/kcfinder/upload/image/stage
// '/uploads/kcfinder/upload/image/stage/'
