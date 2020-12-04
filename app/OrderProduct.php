<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderProduct extends Model
{
    protected $table = "order_products";
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo("App\Order", "order_id");
    }
    public function course()
    {
        return $this->belongsTo("App\Course", "course_id")->withTrashed();
    }
    public function book()
    {
        return $this->belongsTo("App\Book", "book_id");
    }
    public function pack()
    {
        return $this->belongsTo("App\Packs", "pack_id");
    }
    public function quiz()
    {
        return $this->belongsTo("App\Quiz", "quiz_id");
    }
    public function coursetype_variation()
    {
        return $this->belongsTo("App\CourseTypeVariation", "coursetypevariation_id");
    }

    public function orderproducts_students()
    {
        return $this->hasMany("App\OrderproductStudent", "orderproduct_id");
    }
    public function students()
    {
        return $this->belongsToMany("App\Student", "orderproducts_students", "orderproduct_id", "student_id");
    }

    public function orderproducts_unstudents()
    {
        return $this->hasMany("App\OrderproductUnStudent", "orderproduct_id");
    }

    public function isTotalPaid()
    {
		
        $isPaid = false;

        $countOrders = Order::join("order_products", "order_products.order_id", "=", "orders.id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_products.id", $this->id)
            ->where(function ($query) {
                $query->where("order_onlinepayments.payment_status", "paid")
                      ->orWhere("order_onlinepayments.engaged", "engaged");
            })			
            ->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"), "orders.id", "orders.total")
            ->groupBy("orders.id", "orders.total")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->count();

        if ($countOrders > 0)
            $isPaid = true;

        return $isPaid;
    }


    public function   getNameCourse()
    {
        if(!empty($this->course->students_certificates))
        {
                    $query = $this->course->students_certificates ;

            if(($query->where('student_id',auth()->id())->count())>0)
            return $query->where('student_id',auth()->id())->first()->course_name ;
        return null ;
        }
        return null ;
    }
	
}
