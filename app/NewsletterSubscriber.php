<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
   protected $table = "newsletter_subscribers";
	
	public function user(){
		return $this->belongsTo("App\User","user_id");
	}
}
