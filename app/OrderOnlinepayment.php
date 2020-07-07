<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderOnlinepayment extends Model
{
     protected $table="order_onlinepayments";

    public function agent(){
        return $this->belongsTo("App\Agent","agent_id");
    }
    public function order(){
        return $this->belongsTo("App\Order","order_id");
    }
}
