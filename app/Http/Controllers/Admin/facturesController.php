<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\AdminHistory;
use App\User;
use App\Factures;
use App\Facturesdetails;

use Image;
use File;
use DB;
use Excel;

include "./assets/I18N/Arabic.php";
use I18N_Arabic;


class facturesController extends Controller
{
	
	public function __construct() {
		
    }
	
    public function getIndex(){

	  $factures = Factures::get();
      return view('admin.factures.index',array(
      		"factures"=>$factures
		));
    }
   
	

	public function getCreate(){
    	return view('admin.factures.create');
    }
	
	
	public function postCreate(Request $request){
		
		DB::transaction(function() use($request){
		
			$factures = new Factures();
			$factures->client = $request->client;	
			if($request->company!=""){
				$factures->company = $request->company;
			}else{
				$factures->company = '';
			}
			$factures->address = $request->address;
			$factures->email = $request->email;
			$factures->tel = $request->phone;
			if($request->company_invoice!=""){
				$factures->company_invoice = $request->company_invoice;
			}else{
				$factures->company_invoice = 0;
			}
			$factures->discount = $request->discount;
			$factures->save();

			$factures = Factures::get()->last();
			
			for($i=0; $i<sizeof($request->qte); $i++){
				$facturesdetails = new Facturesdetails();
				$facturesdetails->quantite = $request->qte[$i];		   
				$facturesdetails->description = $request->desc[$i];
				$facturesdetails->unite = $request->price[$i];
				$facturesdetails->facture = $factures->id;
				$facturesdetails->save();
			}
				
			/*$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new factures"; 
			$adminhistory->save(); */
			
			Session::flash('alert-success', 'Factures Created Successfully...');
		});
		return redirect("/admin/invoice/create");
   } 
   
   public function getEdit($id){
	   
		$factures=Factures::where("id",$id)->firstOrFail();
		$facturesdetails=Facturesdetails::where("facture",$id)->get();
		
	    return view('admin.factures.edit',array(
	        "factures"=>$factures,
			"facturesdetails"=>$facturesdetails
		));
   }
   
	public function createEdit($id){
	   
		$factures=Factures::where("id",$id)->firstOrFail();
		$Arabic = new I18N_Arabic('Glyphs');
		
		$dir = '/assets/admin/img/';
		if($factures->company_invoice==1){
			$image_path = asset($dir . "sast_facture.jpg");
			$img = Image::make("assets/admin/img/sast_facture.jpg");
			
			// use callback to define details
			if(sizeof($id)<3){
				$idc="00";
			}else{
				$idc="";
			}
			$img->text($idc.$id, 1360, 420, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(52);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
			$img->text(date("d/m/Y"), 2150, 270, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(52);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
			$img->text($factures->client, 1600, 752, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->company, 1600, 820, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->address, 1600, 895, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->email, 1600, 1035, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->tel, 1600, 1130, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			
			$facturesdetails=Facturesdetails::where("facture",$id)->get();
			
			$yf=0;
			$price = 0;

			foreach($facturesdetails as $facturesdetail){
				$img->text($facturesdetail->quantite, 125, 1535+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top'); 
				}); 
				$img->text($Arabic->utf8Glyphs($facturesdetail->description), 520, 1535+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$img->text($facturesdetail->unite." $", 1315, 1535+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$img->text($facturesdetail->unite*$facturesdetail->quantite." $", 2085, 1535+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$yf=$yf+105;
				$price = $price+$facturesdetail->unite*$facturesdetail->quantite;
			}
			$price_tva=($price/100) * 25;
			$img->text("25% = ".$price_tva."$", 2030, 2570, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->discount." $", 2030, 2630, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$tatal = ($price + $price_tva) - $factures->discount;
			$img->text($tatal." $", 2030, 2690, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
		}else{
			$image_path = asset($dir . "gcss_facture.jpg");
			$img = Image::make("assets/admin/img/gcss_facture.jpg");
			
			// use callback to define details
			if(sizeof($id)<3){
				$idc="00";
			}else{
				$idc="";
			}
			$img->text($idc.$id, 1360, 505, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(52);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
			$img->text(date("d/m/Y"), 2150, 325, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(52);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
			$img->text($factures->client, 1600, 772, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->company, 1600, 850, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->address, 1600, 935, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->email, 1600, 1018, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->tel, 1600, 1100, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			
			$facturesdetails=Facturesdetails::where("facture",$id)->get();
			
			$yf=0;
			$price = 0;
			foreach($facturesdetails as $facturesdetail){
				$img->text($facturesdetail->quantite, 125, 1555+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				}); 
				$img->text($Arabic->utf8Glyphs($facturesdetail->description), 520, 1555+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$img->text($facturesdetail->unite." DT", 1315, 1555+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$img->text($facturesdetail->unite*$facturesdetail->quantite." DT", 2085, 1555+$yf, function($font) {
					$font->file('assets/admin/fonts/arial.ttf');
					$font->size(32);
					$font->color('#5a5a5a');
					$font->align('left');
					$font->valign('top');
				});
				$yf=$yf+105;
				$price = $price+$facturesdetail->unite*$facturesdetail->quantite;
			}
			$price_tva=($price/100) * 19;
			$img->text("19% = ".$price_tva." DT", 2000, 2580, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($factures->discount." DT", 2000, 2640, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$tatal = ($price + $price_tva) - $factures->discount;
			$img->text($tatal." DT", 2000, 2700, function($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
		}
		
		// save file as jpg with medium quality
		$img->save('uploads/kcfinder/upload/image/factures/facture'.$id.'.jpg', 100);
		
		//echo "<img src='https://swedish-academy.se/uploads/kcfinder/upload/image/factures/facture".$id.".jpg' style='max-width:100%;' />";
	    return redirect("/admin/invoice/view/".$id);
	}
   
   public function view($id){
	   $factures=Factures::where("id",$id)->firstOrFail();
		
	    return view('admin.factures.view',array(
	        "factures"=>$factures
		));
   }
   
   public function send($id){
		$factures=Factures::where("id",$id)->firstOrFail();

		$mime_boundary = "----MSA Shipping----" . md5(time());
		$subject = "Swedish Academy : Invoice";
		$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$message1 = "--$mime_boundary\n";
		$message1 .= "Content-Type: text/html; charset=UTF-8\n";
		$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
		$message1 .= "<html>\n";
		$message1 .= "<body>";
		$message1 .= "<table width='602'>";
		$message1 .= "<tr>";
		$message1 .= "<td>";
		$message1 .= "<br><img src='https://swedish-academy.se/uploads/kcfinder/upload/image/factures/facture".$factures->id.".jpg' style='max-width:100%;' />";
		$message1 .= "</td>";
		$message1 .= "</tr>";
		$message1 .= '</table>';
		$message1 .= '</body>';
		$message1 .= '</html>';
		mail($factures->email, $subject, $message1, $headers);
		
		Session::flash('alert-success', 'E-mail has been sent Successfully...');
		 
		return redirect("/admin/invoice/view/".$factures->id);
   }
   
   public function postEdit(Request $request,$id){
   		
		DB::transaction(function() use($request,$id){
   			$factures = Factures::find($id); 
			$factures->client = $request->client;
			if($request->company!=""){
				$factures->company = $request->company;
			}
			$factures->address = $request->address;
			$factures->email = $request->email;
			$factures->tel = $request->phone;
			if($request->company_invoice!=""){
				$factures->company_invoice = $request->company_invoice;
			}else{
				$factures->company_invoice = 0;
			}
			$factures->discount = $request->discount;
			$factures->save();
			
			$facturesdetailss=Facturesdetails::where("facture",$id)->get();

			foreach($facturesdetailss as $facturesdetail){
				if($request->get("qte_".$facturesdetail->id)){
					$facturesdetail->quantite = $request->get("qte_".$facturesdetail->id);		   
					$facturesdetail->description = $request->get("desc_".$facturesdetail->id);
					$facturesdetail->unite = $request->get("price_".$facturesdetail->id);
					$facturesdetail->facture = $id;
					$facturesdetail->update();
				}else{
					$facturesdetail->delete();
				}
			}
			if(!empty($request->qte)){
				for($i=0; $i<sizeof($request->qte); $i++){
					$facturesdetailss=Facturesdetails::where("facture",$id)->get();
					$facturesdetailss = new Facturesdetails();
					$facturesdetailss->quantite = $request->qte[$i];		   
					$facturesdetailss->description = $request->desc[$i];
					$facturesdetailss->unite = $request->price[$i];
					$facturesdetailss->facture = $id;
					$facturesdetailss->save();
				}
			}
				
			/*$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update factures"; 
			$adminhistory->save(); */
		   
			Session::flash('alert-success', 'Factures Updated Successfully...');
		});
		return redirect("admin/invoice/edit/".$id);
   }
   
	public function getPDF($id){
		$factures = Factures::findOrFail($id);
		return view("admin.factures.pdf",array("factures"=>$factures));
	}

	
   
   public function postDelete($id){
		$factures = Factures::findOrFail( $id );
		$factures->delete();
				
		/*$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete coupons"; 
		$adminhistory->save();*/
   }
   
   public function getUniqueNumber(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'coupon_number' => '|unique:coupons,coupon_number,'.$id,
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
  

}
