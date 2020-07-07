<?php

namespace App\Http\Controllers\front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use DB;
use App\User;
use App\Order;
use App\Course;
use App\Certificate;
use App\StudentCertificate;
use App\CourseTypeVariation;
use App\OrderOnlinepayment;
use App\OrderProduct;
use App\OrderproductStudent;

include "assets/I18N/Arabic.php";
use I18N_Arabic;

use Carbon\Carbon;
use App\Notifications\CourseNotification;
use App\Notifications\BirthdayNotification;
use App\Notifications\CouponNotif;
use App\Notifications\EmailNotif;

class CronController extends Controller
{
	
    public function cron(){
        $orders = Order::whereDate('updated_at','>',Carbon::today()->subDays(1)->toDateString());
        $admins = \App\Admin::get();
        foreach ($orders as $order ) {
            if($order->totalPaid() > 0){
                Notification::send($admins, new OrderCreated($order->id,$order->total,$order->user()->username,$order));
            }
        }

        $users = User::all();
        foreach ($users as $user) {
            if(Carbon::parse($user->date_of_birth)->isBirthday()){
                try {
                    $coupon_code = $user->setCounpon(30.0);
                    $user->notify(new BirthdayNotification($user->full_name_ar, $coupon_code));
                    print_r($user->full_name_ar.' birthday email sent successfully <br>');
                }catch (\Exception $e) {
                    print_r($user->full_name_ar.' email not supported error <br>');
                }                   
            }
        }

        foreach ($users as $user) {
            $query = "select order_products.course_id from `order_products` inner join `orders` on `order_products`.`order_id` = `orders`.`id` inner join `order_onlinepayments` on `order_onlinepayments`.`order_id` = `orders`.`id` where exists (select * from `orderproducts_students` where `order_products`.`id` = `orderproducts_students`.`orderproduct_id` and `student_id` = ".$user->id.") and `order_onlinepayments`.`payment_status` = 'paid' and `orders`.`created_at` = '".Carbon::today()->subDays(87)->toDateString()."' and `order_products`.`course_id` is not null";
            $paidCourses = DB::select($query);
            print_r('paid courses number for 3 dyas '.count($paidCourses).'<br/>');
            foreach ($paidCourses as $course) {
                if(!is_null($course)){
                    $paidcourse = Course::find($course->course_id);
                    try {
                        $user->notify(new CourseNotification($course->name,$user->username,"3"));
                        print_r($user->full_name_ar.' course reminder email sent successfully before 3 days<br>');
                    }catch (\Exception $e) {
                        print_r($user->full_name_ar.' email not supported error <br>');
                    }                   
                }
            }          
            $query = "select order_products.course_id from `order_products` inner join `orders` on `order_products`.`order_id` = `orders`.`id` inner join `order_onlinepayments` on `order_onlinepayments`.`order_id` = `orders`.`id` where exists (select * from `orderproducts_students` where `order_products`.`id` = `orderproducts_students`.`orderproduct_id` and `student_id` = ".$user->id.") and `order_onlinepayments`.`payment_status` = 'paid' and `orders`.`created_at` = '".Carbon::today()->subDays(30)->toDateString()."' and `order_products`.`course_id` is not null";
            $paidCourses = DB::select($query);
            print_r('paid courses number for 60 days '.count($paidCourses).'<br/>');
            foreach ($paidCourses as $course) {
                if(!is_null($course)){
                    $paidcourse = Course::find($course->course_id);
                    try {
                        $user->notify(new CourseNotification($course->name,$user->username,"60"));
                        print_r($user->full_name_ar.'course reminder email sent successfully before 60 days<br>');
                    }catch (\Exception $e) {
                        print_r($user->full_name_ar.' email not supported error <br>');
                    }                   
                }
            }                
        }

    }
   
    public function pass_script(){
        $course_l1 = Course::find(14);
        $course_l2 = Course::find(15);
        $courseTypeVariation_l2 = CourseTypeVariation::find(25);
        $course_l3 = Course::find(17);
        $courseTypeVariation_l3 = CourseTypeVariation::find(26);
        $users     = User::all();
        foreach ($users as $key => $user) {
            if($course_l2->isTotalPaid($user) && !$course_l2->isSuccess($user)){
                print_r("offered level3 <br>");
                $course_l3->offer($user, $courseTypeVariation_l3);
                $user->notify(new EmailNotif($user,$course_l3,null));
            }
            if($course_l1->isTotalPaid($user) && !$course_l1->isSuccess($user)){
                print_r("offered level2 <br>");
                $course_l2->offer($user, $courseTypeVariation_l2);
                $user->notify(new EmailNotif($user,$course_l2,null));
            }
        }
    }

    public function correction_script(){
        $certificates    = StudentCertificate::where('course_id', 342)->whereDate('created_at', '<', new Carbon('2018-10-18 00:00:00'))->get();
        $new_certificate = Certificate::findOrFail(285); 
        $Arabic          = new I18N_Arabic('Glyphs');
        foreach ($certificates as $key => $certificate) {
            $serialNumber = $certificate->serialNumber ;
            $image = "";
            $new_certificate->export($certificate->student(),$Arabic,$serialNumber,$image,$certificate->date);
            $certificate->delete();
        }
    }

    public function coupons_script(){
        $course_ids = array(27 => 17,  28 => 298,
        29 => 305, 29 => 312, 30 => 317, 30 => 273, 30 => 275, 30 => 276);
        
        foreach($course_ids as $course_id){
            $course = Course::find($course_id);
            $certificates  = StudentCertificate::where('course_id',$course_id)->get(); 
            foreach($certificates as $certificate){
                $user = $certificate->student->user;
                print_r($user->full_name_ar.' '.$user->id.'<br>');
                try {
                    $coupon_code = $user->setCounpon(150.0);
                    $user->notify(new CouponNotif($user, $coupon_code));
                }catch (\Exception $e) {
                    print_r($user->full_name_ar.' email not supported error <br>');
                }
            }
        }
    }

    public function script(Request $request){
        $course_ids = array(1 => 15, 2 => 265, 3 => 267, 4 => 272, 5 => 277, 6 => 283, 7 => 284, 7 => 288, 7 => 293, 7 => 297, 7 => 300, 7 => 302, 7 => 303, 7 => 324);
        
        $courseTypeVariation = CourseTypeVariation::find(106);
        foreach($course_ids as $course_id){
            $course = Course::find($course_id);
            $certificates_sql  = StudentCertificate::where('course_id',$course_id)->toSql(); 
            $certificates  = StudentCertificate::where('course_id',$course_id)->get(); 
            print_r($certificates_sql.' '.$course_id.' '.$certificates->count().'<br>');
            foreach($certificates as $certificate){
                $user = $certificate->student->user;
                print_r($user->full_name_ar.' '.$user->id.'<br>');
                $order = new Order();
                $order->user_id = $user->id;
                $order->payment_method = "cash";
                $total = $courseTypeVariation->price;
                $setting = App('setting');
                $order->vat = $setting->vat*$total/100;
                $order->total = $total + $setting->vat*$total/100;
                $order->save();

                $orderPayment = new OrderOnlinepayment();
                $orderPayment->order_id = $order->id;
                $orderPayment->payment_status = "paid";
                $orderPayment->payment_method = $order->payment_method;

                $orderPayment->total = $order->total;
                $orderPayment->save();

                $orderProduct = new OrderProduct();
                $orderProduct->order_id=$order->id;
                $promoPoints = 0;
                $courseType = $courseTypeVariation->courseType;
                $orderProduct->coursetypevariation_id=$courseTypeVariation->id;
                $orderProduct->course_id=$courseType->course_id;
                $orderProduct->num_students=1;
                $orderProduct->price=$courseTypeVariation->price;
                $orderProduct->total=$courseTypeVariation->price;
                $orderProduct->save();

                $orderProductStudent = new OrderproductStudent();
                $orderProductStudent->orderproduct_id = $orderProduct->id;
                $orderProductStudent->student_id = $user->student->id;
                $orderProductStudent->save();

                try {
                    $user->notify(new EmailNotif($user,$course,$order));
                }catch (\Exception $e) {
                    print_r($user->full_name_ar.' email not supported error <br>');
                }
            }
        }

    }
}
