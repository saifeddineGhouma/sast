<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Student extends Model
{
    protected $table = "students";
    public $incrementing = false;

    public function user()
    {
        return $this->hasOne("App\User", "id", "id");
    }
    
    public function order_products()
    {
        return $this->belongsToMany("App\OrderProduct", "orderproducts_students", "student_id", "orderproduct_id");
    }

    public function paid_courses_ids()
    {

        return $this->order_products()->join("orders", "orders.id", "=", "order_products.order_id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "=", "paid")

            ->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"), "orders.id", "orders.total")
            ->groupBy("orders.id", "orders.total")->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->pluck("orders.course_id")->all();
    }

    public function student_quizzes()
    {
        return $this->hasMany("App\StudentQuiz", "student_id");
    }

    public function student_videoexams()
    {
        return $this->hasMany("App\StudentVideoExam", "student_id");
    }

    public function students_certificates()
    {
        return $this->hasMany("App\StudentCertificate", "student_id");
    }

    public function user_cas_exam()
    {
        return $this->hasMany("App\UserCasExamPratique", "user_id");
    }
    public function user_stage()
    {
        return $this->hasMany("App\StudentStage", "user_id");
    }
    public function scopeNotBlocked($query)
    {
        return $query->where('blocked', 0);
    }
}
