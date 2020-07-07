<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Factures extends Model
{
	protected $table = "factures";
    public $timestamps = false;
	
    protected $fillable = [
        'client',
        'company',
        'address',
        'email',
        'tel'
    ];

}