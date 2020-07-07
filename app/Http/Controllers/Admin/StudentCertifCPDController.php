<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\UserVerify;
use App\Course;
use App\User;
use File;
use DB;
use App\Notifications\AcceptFile;
use Notification;

class StudentCertifCPDController extends Controller
{
    public function __construct()
    {
    }
    public function getUserVerifyCPD()
    {
        $userverify = UserVerify::whereNotNull('url_certif')->get();
        $courses = Course::all();
        $users = User::all();


        return view('admin.userCPD.index', [
            "userverify" => $userverify, "courses" => $courses, 'users' => $users
        ]);
    }
    public function UpdateVerifyCPD($valid, UserVerify $userverify)
    {
        $userverify->verify = $valid;
        $userverify->update();

        $mime_boundary = "----MSA Shipping----" . md5(time());
        $subject = "Swedish Academy : Verify Files";
        $headers = "From:Swedish Academy<info@swedish-academy.se> \n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $message1 = "--$mime_boundary\n";
        $message1 .= "Content-Type: text/html; charset=UTF-8\n";
        $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
        $message1 .= "<html>\n";
        $message1 .= "<body>";
        $message1 .= "<table width='602'>";
        $message1 .= "<tr>";
        $message1 .= "<td>";
        $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'><br>";
        $message1 .= "</td>";
        $message1 .= "</tr>";
        $message1 .= "<tr>";
        $message1 .= "<td align='right'>";
        $message1 .= "مرحبا بكم <br>
                                      
                                        لقد تم التثبت من الوثائق يمكنك الأن شراء الدورة   <br>
                                        مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام
                                                       ";
        $message1 .= "</td>";
        $message1 .= "</tr>";
        $message1 .= '</table>';
        $message1 .= '</body>';
        $message1 .= '</html>';
        mail($userverify->user->email, $subject, $message1, $headers);


        return redirect()->back();
    }
    public function ViewCertifVerify(UserVerify $userverify)
    {
        return response()->file('uploads/kcfinder/upload/image/verifyCertif/' . $userverify->url_certif);
        //	return redirect()->back();
    }
}
