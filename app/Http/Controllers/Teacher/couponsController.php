<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\Coupon;

use DB;

class couponsController extends Controller
{
	public function __construct() {
		
    }
	
    public function getIndex(){
	  $coupons = Coupon::get();
	  
      return view('teachers.coupons.index',array(
      		"coupons"=>$coupons
		));
    }
   
  

}
