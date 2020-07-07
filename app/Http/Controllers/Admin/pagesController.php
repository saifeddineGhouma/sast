<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Validator;

use App\AdminHistory;
use App\Shop;
use App\Page;
use App\PageTranslation;
use DB;

class pagesController extends Controller
{
	public function __construct() {
		/*if(!Auth::guard("admins")->user()->can("general")){
           echo view("admin.not_authorized");
			die;
        }*/
    }
	
     public function getIndex()
    {
//        if(!Auth::guard("admins")->user()->can("general")){
//           return view("admin.not_authorized");
//        }
        $pages = Page::get();
		
        return view('admin.pages.index',	array(
        			'pages'=>$pages
		)); 
    }
	
    public function getCreate(){
    	$fontArray = array(
			"ti-info"=>"info",
			"ti-star"=>"star",
			"ti-image"=>"image",
			"ti-package"=>"package",
			"ti-email"=>"email"
		);
		
		session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		     	
       return view('admin.pages.create',array("fontArray"=>$fontArray));
     }
	
	public function postCreate(Request $request){
		DB::transaction(function() use($request){	   		 
			$page = new Page();
			$page->font=$request->get("font");
			if($request->active)
				$page->active = 1;
			else
				$page->active = 0;			
			$page->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new page"; 
			$adminhistory->save(); 
			
			$page_trans = new PageTranslation();
			$page_trans->page_id = $page->id;
			$page_trans->title = $request->en_title;
			$page_trans->slug = $request->en_slug;
			$page_trans->content = $request->en_content;			
			$page_trans->meta_title = $request->en_meta_title;
			$page_trans->meta_keyword = $request->en_meta_keyword;
			$page_trans->meta_description = $request->en_meta_description;
			$page_trans->lang = "en";
			$page_trans->save();
			
			if($request->ar_slug != ""){
				$page_trans = new PageTranslation();
				$page_trans->page_id = $page->id;
				$page_trans->title = $request->ar_title;
				$page_trans->slug = $request->ar_slug;
				$page_trans->content = $request->ar_content;			
				$page_trans->meta_title = $request->ar_meta_title;
				$page_trans->meta_keyword = $request->ar_meta_keyword;
				$page_trans->meta_description = $request->ar_meta_description;
				$page_trans->lang = "ar";
				$page_trans->save();
				
			}
			Session::flash('alert-success', 'Page has been Inserted Successfully...');
		}); 
		return redirect("/admin/pages/create");
		
	}
	
	public function getEdit($id){
		$fontArray = array(
			"ti-info"=>"info",
			"ti-star"=>"star",
			"ti-image"=>"image",
			"ti-package"=>"package",
			"ti-email"=>"email"
		);

        $page = Page::where("id",$id)->firstOrFail();
		
		
		 session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		 
		return view('admin.pages.edit',array('page'=>$page,"fontArray"=>$fontArray));
	}
	
	public function postEdit(Request $request,$id){
		
		DB::transaction(function() use($request,$id){	   
			$page = Page::find($id);
			$page->font=$request->get("font");
			if($request->active)
				$page->active = 1;
			else
				$page->active = 0;	
			$page->save();	
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update page"; 
			$adminhistory->save(); 
			
			$page_trans = PageTranslation::where("page_id",$id)->where("lang","en")->first();	
			if(empty($page_trans))
				$page_trans = new PageTranslation();	
			$page_trans->page_id = $page->id;
			$page_trans->title = $request->en_title;
			$page_trans->slug = $request->en_slug;
			$page_trans->content = $request->en_content;			
			$page_trans->meta_title = $request->en_meta_title;
			$page_trans->meta_keyword = $request->en_meta_keyword;
			$page_trans->meta_description = $request->en_meta_description;
			$page_trans->lang = "en";
			$page_trans->save();
			
			if($request->ar_slug != ""){
				$page_trans = PageTranslation::where("page_id",$id)->where("lang","ar")->first();	
				if(empty($page_trans))
					$page_trans = new PageTranslation();
				$page_trans->page_id = $page->id;
				$page_trans->title = $request->ar_title;
				$page_trans->slug = $request->ar_slug;
				$page_trans->content = $request->ar_content;			
				$page_trans->meta_title = $request->ar_meta_title;
				$page_trans->meta_keyword = $request->ar_meta_keyword;
				$page_trans->meta_description = $request->ar_meta_description;
				$page_trans->lang = "ar";
				$page_trans->save();				
			}
			
			Session::flash('alert-success', 'Page has been Updated Successfully...');
		});			   
		return redirect("/admin/pages/edit/".$id);
		
	}
	
	
	public function postDelete($id){
		$page = Page::findOrFail( $id );
		
		$page->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete page"; 
		$adminhistory->save(); 
	}
	public function getCheckhome(){
		$pagecount = Page::where('in_home',1)->count();
		echo $pagecount;
	}
	public function getCheckfooter(){
		$pagecount = Page::where('in_footer',1)->count();
		echo $pagecount;
	}
	
	public function getUniqueSlug(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'slug' => '|unique:pages_translations,slug,'.$id.',page_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
	
	public function postUpdatestateajax(Request $request){
		$ID = $request->get("sp");
		$newsate =$request->get("newsate");
		$field = $request->get("field");	
		
		if($newsate=='true'){
			$newsate = 1;
		}else{
			$newsate = 0;
		}
		
		$page = Page::find($ID);
		$page->$field=$newsate;
		$page->update();	
		
	}
	
	
	
}
