<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CourseTypeVariation extends Model
{
    protected $table="coursetype_variations";
    public $timestamps = false;


    public function courseType(){
        return $this->belongsTo("App\CourseType","coursetype_id");
    }

    public function teacher(){
        return $this->belongsTo("App\Teacher");
    }

    public function government(){
        return $this->belongsTo("App\Government","govern_id");
    }

    public function certificate(){
        return $this->belongsTo("App\Certificate","certificate_id");
    }

    public function order_products(){
        return $this->hasMany("App\OrderProduct","coursetypevariation_id");
    }

    public function students(){
        $studentIds = $this->order_products()->join("orderproducts_students","orderproducts_students.orderproduct_id","=","order_products.id")
            ->join("orders", "order_products.order_id", "=", "orders.id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")

        ->pluck("student_id")->all();
        $students = \App\Student::whereIn("id",$studentIds)->get();
        return $students;
    }
}
   
