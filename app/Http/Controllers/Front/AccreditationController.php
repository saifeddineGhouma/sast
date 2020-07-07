<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

use App\News;
use App\NewsView;

use Session;
use Auth;
use DB;

class AccreditationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */   
	public function index(){					
		return view('front.accreditation.index');
	}
	
	public function submit(Request $request){
		$user = Auth::user();
		if($request->accreditation_type == 'مؤسسة'){
	        if(Input::hasFile('file_company')){
	            $image= $request->file('file_company');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_company = $imageName;
	        }
	        
	        $website = $request->website;
	        $courses = $request->courses;
	        if(Input::hasFile('file_courses')){
	            $image= $request->file('file_courses');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_courses = $imageName;
	        }
	        $accredited_courses = $request->accredited_courses;
	        $other_courses = $request->other_courses;
	        if(Input::hasFile('file_other_courses')){
	            $image= $request->file('file_other_courses');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_other_courses = $imageName;
	        }
	        $c_marketing_plan = $request->c_marketing_plan;
	        if(Input::hasFile('file_c_marketing_plan')){
	            $image= $request->file('file_c_marketing_plan');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_c_marketing_plan = $imageName;
	        }
	        $other_accreditation = $request->other_accreditation;
	        if(Input::hasFile('file_other_accreditation')){
	            $image= $request->file('file_other_accreditation');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_other_accreditation = $imageName;
	        }
	        $other_accreditation_world = $request->other_accreditation_world;
	        if(Input::hasFile('file_other_accreditation_world')){
	            $image= $request->file('file_other_accreditation_world');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_other_accreditation_world = $imageName;
	        }
	        $users_review = $request->users_review;
	        if(Input::hasFile('file_users_review')){
	            $image= $request->file('file_users_review');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_users_review = $imageName;
	        }
	        $coachs = $request->coachs;
	        if(Input::hasFile('file_coachs')){
	            $image= $request->file('file_coachs');
	            $imageName=$image->getClientOriginalName();
	            $rnd = str_random(2);
	            $imageName = $rnd.$imageName;
	            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
	            $file_coachs = $imageName;
	        }
	        $other_centers = $request->other_centers; 
	        if(Input::hasFile('other_infos')){
	        	foreach ($request->other_infos as $image) {
		            $imageName=$image->getClientOriginalName();
		            $rnd = str_random(2);
		            $imageName = $rnd.$imageName;
		            $image->move('uploads/kcfinder/upload/image/accreditation/',$imageName);
		            $other_infos = $imageName;
		        }
	        }

		}

	}	

}
