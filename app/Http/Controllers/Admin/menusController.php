<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Page;
use App\MenuLink;
use App\MenuLinkTranslation;
use App\Menu;
use App\MenuPos;
use App\Shop;
use Auth;
use DB;

class menusController extends Controller
{
	public function __construct() {

    }
	
    public function getIndex(){
//        if(!Auth::guard("admins")->user()->can("general")){
//            echo view("admin.not_authorized");
//            die;
//        }
    	$pages = Page::get();
		$menuposes = MenuPos::get();
		$mainMenus = Menu::get();
		
    	return view("admin.menus.index",array(
    		"pages"=>$pages,"menuposes"=>$menuposes,
    		"mainMenus"=>$mainMenus
		));
    }
	
	public function getLinks($menuId){
		$menu = Menu::find($menuId);
		$parentLinks = MenuLink::where("menu_id",$menuId)->where("parent_id",0)->orderBy("sort_order","asc")->get();

		
		return view("admin.menus.links",array(
			"parentLinks"=>$parentLinks,"menuId"=>$menuId,"menuName"=>$menu->name,
			"menu"=>$menu
		));
	}
	
	public function getTest(){
		$lastId = MenuLink::orderBy('id','desc')->first()->id;
		echo $lastId;
	}
	 public function postSavetree(Request $request){
	 	DB::transaction(function() use($request){	
		 	$data = $request->get('data');
			$menuId = $request->get('menuId');
			$menu = Menu::find($menuId);
			$menu->name = $request->get('menuName');
			if($request->get('ar_menuName'))
				$menu->name_ar = $request->get('ar_menuName');
			$menu->save();
			
			$treeIds = array();
			if(!empty($data)){
				foreach($data as $link1){
					$menulink = new MenuLink;
					$menulink->id = $link1["id"];
					$menulink->menu_id = $menuId;
					$menulink->link_type = $link1["link_type"];
					if($link1["open_window"]=="on")
						$menulink->open_window = 1;
					else
						$menulink->open_window = 0;				
					$menulink->sort_order = $link1["sort_order"];
					$menulink->parent_id = 0;
					$menulink->settings = $link1["settings"];
					
					$menulink->save();
					
					$names = explode(":=:", $link1["name"]);
					
					$menulink_trans = new MenuLinkTranslation();
					$menulink_trans->menulink_id = $menulink->id;
					$menulink_trans->name = $names[0];				
					$menulink_trans->lang = "ar";
					$menulink_trans->save();
					
					if($names[1] != ""){
						$menulink_trans = new MenuLinkTranslation();
						$menulink_trans->menulink_id = $menulink->id;
						$menulink_trans->name = $names[1];				
						$menulink_trans->lang = "en";
						$menulink_trans->save();
					}
					
					
					$menulink->name = $link1["name"];
					
					array_push($treeIds,$menulink->id);
				}
			}
			
			
			$data1 = json_decode($request->get('jsontree'));
			
			$sortOrder = 1;
		 	foreach($data1 as $parent){
		 		$this->recurseTree($parent,0,$treeIds,$sortOrder);
				$sortOrder++;
		 	}
			
			$deleteLinks = MenuLink::where('menu_id',$menuId)->whereNotIn('id', $treeIds)->get();
			if(!$deleteLinks->isEmpty()){
				foreach($deleteLinks as $deletelink){
					$deletelink->delete();
				}
			}
		});
		
	 }
	
	 public function recurseTree($current,$parent,&$treeIds,$sortOrder){
	 	$this->updateParent($current->id, $parent,$sortOrder);
		array_push($treeIds,$current->id);
		if(isset($current->children)){
			$childs = $current->children;
			$sortOrder = 1;
			foreach($childs as $child){
		 		$this->recurseTree($child,$current->id,$treeIds,$sortOrder);
				$sortOrder++;
		 	}
		}
	 }
	 public function updateParent($id,$parentId,$sortOrder){
	 	$parentModel = MenuLink::find($id);
		if(!empty($parentModel)){
			$parentModel->parent_id = $parentId;
			$parentModel->sort_order = $sortOrder;
			$parentModel->update();
		}		
		
	 }
	 public function postAddmenu(Request $request){
		$menu = new Menu;
		$menu->name = $request->get('name');		
		$menu->save();
		echo $menu->id;
	 }
	 public function postDeletemenu(Request $request){
		$menu = Menu::find($request->get('menuId'));
		$menu->delete();		
	 }
	 
	 public function getTab2content(Request $request){
		$menuposes = MenuPos::get();
		
		return view("admin.menus._tab2",array(
			"menuposes"=>$menuposes
		));
	 }
	 
	 public function postSavemenupos(Request $request){
	 	$data = $request->get('data');
	 	foreach($data as $key=>$val){
	 		$menupos = MenuPos::find($key);
			$menus = array();
			if($val!=0)
				array_push($menus,$val);
			$menupos->menus()->sync($menus);
	 	}
	 }
}
