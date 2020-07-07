<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\Packs;

use Auth;
use DB;

class PacksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	

	public function getIndex(){
        $packs = Packs::where('active',1)->get();
        return view("front.packs.index",array(
            "packs"=>$packs
        ));
    }

	public function getView($packs_id){
		$packs = Packs::findOrFail($packs_id);
		$user = Auth::user();
        return view("front.packs.view",array(
            "packs"=>$packs,
			"user"=>$user
        ));
    }
	
	
}
