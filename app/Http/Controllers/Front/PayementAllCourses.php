<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Admin;

use App\Order;
use App\OrderProduct;
use App\OrderproductVariation;
use App\OrderOnlinepayment;
use App\OrderproductStudent;
use App\OrderproductUnStudent;
use App\CourseTypeVariation;

class PayementAllCourses extends Controller
{
    public function payementAllCourse(Request $request)
    {
        $coursetypevariations = CourseTypeVariation::all();


        foreach ($coursetypevariations as $courseTypeVariation) {
            if ($courseTypeVariation->courseType->course->active == 1) {
                if (in_array($courseTypeVariation->govern_id, [null, 73])) {
                    if ($courseTypeVariation->courseType->type == "online") {
                        $order = new Order();
                        $order->user_id = 16868;
                        $order->payment_method = "cash";
                        $total = $courseTypeVariation->price;
                        $setting = App('setting');
                        $order->vat = $setting->vat * $total / 100;
                        $order->total = $total + $setting->vat * $total / 100;
                        $order->save();

                        $orderPayment = new OrderOnlinepayment();
                        $orderPayment->order_id = $order->id;
                        $orderPayment->payment_status = "paid";
                        $orderPayment->payment_method = $order->payment_method;
                        $orderPayment->total = $order->total;
                        $orderPayment->save();

                        $orderProduct = new OrderProduct();
                        $orderProduct->order_id = $order->id;
                        $courseType = $courseTypeVariation->courseType;
                        $orderProduct->coursetypevariation_id = $courseTypeVariation->id;
                        $orderProduct->course_id = $courseType->course_id;
                        $orderProduct->num_students = 1;
                        $orderProduct->price = $courseTypeVariation->price;
                        $orderProduct->total = $courseTypeVariation->price;
                        $orderProduct->save();

                        $orderProductStudent = new OrderproductStudent();
                        $orderProductStudent->orderproduct_id = $orderProduct->id;
                        $orderProductStudent->student_id =  16868;
                        $orderProductStudent->save();
                    }
                }
            }
        }
    }
}
