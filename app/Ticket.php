<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $table = "ticket";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'parent',
        'message',
    ];
	
	public function user(){
		return $this->belongsTo("App\User","user_id");
	}
    
}
