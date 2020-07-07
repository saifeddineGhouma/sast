<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderproductStudent extends Model
{
     protected $table="orderproducts_students";
	 public $timestamps = false;

    public function orderproduct(){
        return $this->belongsTo("App\OrderProduct","orderproduct_id");
    }
    public function student(){
        return $this->belongsTo("App\Student","student_id");
    }
}
