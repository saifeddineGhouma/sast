<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Setting;
use App\SettingTranslation;
use App\SettingSocial;
use App\SettingSliderimage;
use App\MetaData;

use App\AdminHistory;
use File;
use DB;

class SettingsController extends Controller
{
   public function __construct() {

    }
   
   public function getEdit(){
//       if(!Auth::guard("admins")->user()->can("settings")){
//           echo view("admin.not_authorized");
//           die;
//       }
	   	$setting = Setting::findOrFail(1);
		$socialArray = array(
			"fa fa-facebook"=>"facebook",
			"fa fa-twitter"=>"twitter",
			"fa fa-google-plus"=>"googleplus",
			"fa fa-instagram"=>"instagram",
			"fa fa-linkedin"=>"linkedin",
            "fa fa-youtube"=>"youtube",
			"fa fa-rss"=>"rss",
			"fa fa-amazon"=>"amazon",
			"fa fa-delicious"=>"delicious",
			"fa fa-dribbble"=>"dribbble",
			"fa fa-flickr"=>"flickr",
			"fa fa-linkedin"=>"linkedin",
			"fa fa-pinterest-p"=>"pinterest-p",
			"fa fa-skype"=>"skype",
			"fa fa-snapchat-ghost"=>"snapchat-ghost",
			"fa fa-tumblr"=>"tumblr",
			"fa fa-telegram"=>"telegram",
			"fa fa-vimeo"=>"vimeo",
		); 
		$metaData_en = MetaData::where("lang","en")->get();
		$metaData_ar = MetaData::where("lang","ar")->get();
        session_start();//to enable kcfinder for authenticated users
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

       return view("admin.settings.edit",compact('setting','socialArray','metaData_en','metaData_ar'));
   }
   public function postEdit(Request $request){
   		DB::transaction(function() use($request){	   
		   	$setting = Setting::find(1);
		   	
			$setting->phone = $request->phone;
			$setting->mobile = $request->mobile;
			$setting->email = $request->email;
            $setting->map = $request->map;
            $setting->vat = $request->vat;
            $setting->points = $request->points;
            $setting->points_value = $request->points_value;
            $setting->max_points_replace = $request->max_points_replace;
            $setting->paypal_client_id = $request->paypal_client_id;
            $setting->paypal_secret = $request->paypal_secret;
		   	$setting->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update Public Settings"; 
			$adminhistory->save(); 
			
			
			$setting_trans = SettingTranslation::where("setting_id",1)->where("lang","ar")->first();	
			if(empty($setting_trans))
				$setting_trans = new SettingTranslation();
			$setting_trans->setting_id = 1;			
			$setting_trans->site_name = $request->ar_site_name;
            $setting_trans->time_work = $request->ar_time_work;
			$setting_trans->logo = $request->ar_logo;
			$setting_trans->address = $request->ar_address;
			$setting_trans->footer_text = $request->ar_footer_text;	
			$setting_trans->contact_description = $request->ar_contact_description;
			$setting_trans->index_section = $request->ar_index_section;
            $setting_trans->index_section2 = $request->ar_index_section2;
            $setting_trans->footer_about = $request->ar_footer_about;
			
			$setting_trans->meta_title = $request->ar_meta_title;		
			$setting_trans->meta_keyword = $request->ar_meta_keyword;
			$setting_trans->meta_description = $request->ar_meta_desc;;	
			$setting_trans->lang = "ar";		
			$setting_trans->save();
			
			$setting_trans = SettingTranslation::where("setting_id",1)->where("lang","en")->first();	
			if(empty($setting_trans))
				$setting_trans = new SettingTranslation();
			$setting_trans->setting_id = 1;			
			$setting_trans->site_name = $request->en_site_name;
            $setting_trans->time_work = $request->en_time_work;
			$setting_trans->logo = $request->en_logo;
			$setting_trans->address = $request->en_address;
			$setting_trans->footer_text = $request->en_footer_text;
            $setting_trans->contact_description = $request->en_contact_description;
            $setting_trans->index_section = $request->en_index_section;
            $setting_trans->index_section2 = $request->en_index_section2;
            $setting_trans->footer_about = $request->en_footer_about;
			
			$setting_trans->meta_title = $request->en_meta_title;		
			$setting_trans->meta_keyword = $request->en_meta_keyword;
			$setting_trans->meta_description = $request->en_meta_desc;;	
			$setting_trans->lang = "en";		
			$setting_trans->save();
			
			$this->saveSocials($request,$setting);
			$this->saveSliderImages($request,$setting);
			
			$metaDatas = MetaData::get();
			$meta_title = $request->get("meta_title");
			$meta_keyword = $request->get("meta_keyword");
			$meta_description = $request->get("meta_description");
			
			foreach($metaDatas as $metaData){
				$metaData->title = $meta_title[$metaData->id];
				$metaData->keyword = $meta_keyword[$metaData->id];
				$metaData->description = $meta_description[$metaData->id];
				$metaData->save();
			}
			
			Session::flash('alert-success', 'Settings updated succussfully ...');
		});
   		
		return redirect("/admin/settings/edit");

   }

	public function saveSocials($request,$setting){
		
		//*********** update current socials***********
		foreach($setting->socials as $social){
			if($request->get("social_name_".$social->id)){
				$social->name = $request->get("social_name_".$social->id);
				$social->font = $request->get("social_font_".$social->id);
				$social->link = $request->get("social_link_".$social->id);
				$social->update();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current socials"; 
				$adminhistory->save(); 
			}else{
				$social->delete();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete socials"; 
				$adminhistory->save(); 
			}
		}
		
		//***********Insert new downloadlink****************
		$socials = $request->get("socials");
		if(!empty($socials)){
			foreach($socials as $social){
				$settingSocial = new SettingSocial();
				$settingSocial->setting_id = $setting->id;
				$settingSocial->name = $social["name"];
				$settingSocial->font = $social["font"];
				$settingSocial->link = $social["link"];
				$settingSocial->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add socials"; 
				$adminhistory->save(); 
			}
		}
	}
	
	public function saveSliderImages($request,$setting){		
		//*********** update current sliderimages***********
		foreach($setting->sliderimages as $image){
			if($request->get("sliderimage_image_".$image->id)){
				$image->image = $request->get("sliderimage_image_".$image->id);
				$image->title = $request->get("sliderimage_title_".$image->id);
				$image->description = $request->get("sliderimage_description_".$image->id);
				$image->link = $request->get("sliderimage_link_".$image->id);
				$image->sort_order = $request->get("sliderimage_sortorder_".$image->id);
				if($request->get("sliderimage_active_".$image->id)){
					$image->active = 1;
				}else{
					$image->active = 0;	
				}
				$image->update();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current sliderimages"; 
				$adminhistory->save(); 
			}else{
				$image->delete();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete sliderimages"; 
				$adminhistory->save();
			}
		}
		
		//***********Insert new sliderimage****************
		$sliderimages = $request->get("sliderimage_en");
		$this->insertNewImage($request, $setting, $sliderimages,"en");
		
		$sliderimages = $request->get("sliderimage_ar");
		$this->insertNewImage($request, $setting, $sliderimages,"ar");
		
	}

	public function insertNewImage($request,$setting,$sliderimages,$lang){
		if(!empty($sliderimages)){
			foreach($sliderimages as $sliderimage){
				$image = new SettingSliderimage();
				$image->settings_id = $setting->id;
				$image->image = $sliderimage["image"];
				$image->title = $sliderimage["title"];
				$image->description = $sliderimage["description"];
				
				$image->link = $sliderimage["link"];
				$image->sort_order = $sliderimage["sort_order"];
				if($sliderimage["active"]){
					$image->active = 1;
				}else{
					$image->active = 0;	
				}
				$image->lang = $lang;
				$image->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add sliderimages"; 
				$adminhistory->save();
			}
		}
	}
   
   
  public function postDeleteimaeajax(Request $request){
		
		$data = json_decode(stripslashes( $request->get("data")), true);		
		
		File::delete('uploads/settings/'. $data[1]);
		
		$setting = Setting::find($data[0]);
		$setting->image = Null;
		$setting->update();	
		
		return view('admin.settings._images',array('setting'=>new Setting));
       
	}
	

}
