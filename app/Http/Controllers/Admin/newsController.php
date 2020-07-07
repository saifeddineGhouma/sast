<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Admin;
use App\Student;
use App\User;
use App\News;
use App\NewsTranslation;

use App\AdminHistory;
use DB;

class newsController extends Controller
{
	public function __construct() {
		/*if(!Auth::guard("admins")->user()->can("all")){
           abort(404);
        }*/
    }
	
    public function getIndex(){
     
	  $admins = Admin::get();
	  
      return view('admin.news.index',array(
      		"admins"=>$admins
		));
    }
   
	
	public function getSearchresults(Request $request)
    {
    	$title = $request->title;
		$created_at = $request->created_at;
		$admin_id = $request->admin_id;
		
		
    	$news = News::with("publisher");
		
		if($title!=""){
			$news = $news->join("news_translations","news.id","=","news_translations.news_id");
			$news = $news->where('news_translations.title','like','%'.$title.'%');
		}
    		
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
			$news = $news->where(DB::raw("DATE(created_at)"),$created_at);
		}
		if($admin_id != "0")
			$news = $news->where('publisher_id',$admin_id);
		
		$news = $news->distinct()->get(["news.*"]);	
		
		return view('admin.news._search_results',	array(
        			'news'=>$news			
		)); 
    }
	
	public function getCreate() {
       session_start();//to enable kcfinder for authenticated users
		$_SESSION['KCFINDER'] = array();
		$_SESSION['KCFINDER']['disabled'] = false; 
		
       return view("admin.news.create");
    }

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
			$news = new News();
			$news->image = $request->image;
			$news->thumbnail = $request->thumbnail;
			$news->publisher_id = Auth::guard("admins")->user()->id;
			if($request->active)
				$news->active =  1;
			else {
				$news->active =  0;
			}
			$news->type = $request->type;
			$news->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new new"; 
			$adminhistory->save(); 
			
			$news_trans = new NewsTranslation();
			$news_trans->news_id = $news->id;
			$news_trans->title = $request->ar_title;
			$news_trans->slug = trim($request->ar_slug);
			$news_trans->short_description = $request->ar_short_description;
			$news_trans->content = $request->ar_content;
			$news_trans->meta_title = $request->ar_meta_title;
			$news_trans->meta_keyword = $request->ar_meta_keyword;
			$news_trans->meta_description = $request->ar_meta_description;
			$news_trans->lang = "ar";
			$news_trans->save();
			
			
			if($request->en_slug != ""){
				$news_trans = new NewsTranslation();
				$news_trans->news_id = $news->id;
				$news_trans->title = $request->en_title;
				$news_trans->slug = trim($request->en_slug);
				$news_trans->short_description = $request->en_short_description;
				$news_trans->content = $request->en_content;
				$news_trans->meta_title = $request->en_meta_title;
				$news_trans->meta_keyword = $request->en_meta_keyword;
				$news_trans->meta_description = $request->en_meta_description;
				$news_trans->lang = "en";
				$news_trans->save();
			}
			
			//echo $news->id;
			$newss = News::findOrFail($news->id);
			//echo $newss->news_trans('ar')->slug; 
			//die();
			$users = User::get();
			/*foreach ($users as $userss) {
				$to = $userss->email;
				$mime_boundary = "----MSA Shipping----" . md5(time());
				$subject = "Swedish Academy: New publication";
				$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
				$message1 = "--$mime_boundary\n";
				$message1 .= "Content-Type: text/html; charset=UTF-8\n";
				$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
				$message1 .= "<html>\n";
				$message1 .= "<body>";
				$message1 .= "<table width='800'>";
				$message1 .= "<tr>";
				$message1 .= "<td>";
				$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= "<a href='https://swedish-academy.se/publication/article/".$newss->news_trans('ar')->slug."'>أنقر هنا</a>";
				$message1 .= '</body>';
				$message1 .= '</html>';
				mail($to, $subject, $message1, $headers);
			}*/
			
			$admins = Admin::get();
			foreach ($admins as $adminss) {
				$to = $adminss->email;
				$mime_boundary = "----MSA Shipping----" . md5(time());
				$subject = "Swedish Academy: New publication";
				$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
				$message1 = "--$mime_boundary\n";
				$message1 .= "Content-Type: text/html; charset=UTF-8\n";
				$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
				$message1 .= "<html>\n";
				$message1 .= "<body>";
				$message1 .= "<table width='800'>";
				$message1 .= "<tr>";
				$message1 .= "<td>";
				$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= "<a href='https://swedish-academy.se/publication/article/".$newss->news_trans('ar')->slug."'>أنقر هنا</a>";
				$message1 .= '</body>';
				$message1 .= '</html>';
				mail($to, $subject, $message1, $headers);
			}
		});
		
		$students = Student::join("users","students.id","=","users.id");
		
 		Session::flash('news_inserted', 'News has been added succesfully...');
       return redirect("admin/news/create");
    }
	
	public function getEdit($id){
		$news = News::find($id);
		session_start();//to enable kcfinder for authenticated users
		$_SESSION['KCFINDER'] = array();
		$_SESSION['KCFINDER']['disabled'] = false; 
		return view("admin.news.edit",array(
			"news"=>$news	
		));
	}
	public function postEdit(Request $request,$id){
		DB::transaction(function() use($request,$id){
			$news = News::findOrFail($id);
			$news->image = $request->image;
			$news->thumbnail = $request->thumbnail;
			if($request->active)
				$news->active =  1;
			else {
				$news->active =  0;
			}
			$news->type = $request->type;
			$news->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update new"; 
			$adminhistory->save(); 
			
			$news_trans = NewsTranslation::where("news_id",$id)->where("lang","ar")->first();	
			if(empty($news_trans))
				$news_trans = new NewsTranslation();
			$news_trans->news_id = $news->id;
			$news_trans->slug = trim($request->ar_slug);
			$news_trans->title = $request->ar_title;
			$news_trans->short_description = $request->ar_short_description;
			$news_trans->content = $request->ar_content;
			$news_trans->meta_title = $request->ar_meta_title;
			$news_trans->meta_keyword = $request->ar_meta_keyword;
			$news_trans->meta_description = $request->ar_meta_description;
			$news_trans->lang = "ar";
			$news_trans->save();			
			
			if($request->en_slug != ""){
				$news_trans = NewsTranslation::where("news_id",$id)->where("lang","en")->first();	
				if(empty($news_trans))
					$news_trans = new NewsTranslation();
				$news_trans->news_id = $news->id;
				$news_trans->slug = trim($request->en_slug);
				$news_trans->title = $request->en_title;
				$news_trans->short_description = $request->en_short_description;
				$news_trans->content = $request->en_content;
				$news_trans->meta_title = $request->en_meta_title;
				$news_trans->meta_keyword = $request->en_meta_keyword;
				$news_trans->meta_description = $request->en_meta_description;
				$news_trans->lang = "en";
				$news_trans->save();
			}
		});
		
		Session::flash('news_updated', 'News has been updated succesfully...');
		return redirect("admin/news/edit/".$id);
	}
	public function postDelete($id){
		$news = News::findOrFail( $id );		
		$news->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete new"; 
		$adminhistory->save(); 
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
		
		$news = News::find($ID);
		$news->$field=$newsate;
		$news->update();	
	}
	
	 public function getUniqueSlug(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'slug' => '|unique:news_translations,slug,'.$id.',news_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}   
  
	

}
