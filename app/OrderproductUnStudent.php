<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderproductUnStudent extends Model
{
     protected $table="orderproducts_unstudents";
	 public $timestamps = false;

    public function orderproduct(){
        return $this->belongsTo("App\OrderProduct","orderproduct_id");
    }

}
