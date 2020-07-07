<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Facturesdetails extends Model
{
	protected $table = "factures_details";
    public $timestamps = false;
	
    protected $fillable = [
        'quantite',
        'description',
        'unite',
        'facture'
    ];

}