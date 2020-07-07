<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BookOrder extends Model
{
    protected $table="book_orders";

	
	public function user(){
		return $this->belongsTo("App\User","user_id");
	}
	
	public function book(){
		return $this->belongsTo("App\Book","book_id");
	}
}
