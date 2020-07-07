<?php 
use App\MenuLink;
function getTree($parent,$menuId){
	$enname = "";
	if(!empty($parent->menulink_trans("en")))
		$enname = $parent->menulink_trans("en")->name;
	echo '<li class="dd-item dd3-item" data-id="'.$parent->id.'" id="'.$parent->id.
	'" link-type="'.$parent->link_type.'" open-window="'.$parent->open_window.'" settings="'.$parent->settings.'">';
	echo '<div class="dd-handle dd3-handle"></div>';
	echo '<span class="class2"><button id="delete-'.$parent->id.'" class="delete">delete</button></span>';
	echo '<div class="dd3-content">'.$parent->menulink_trans("ar")->name.':=:'.$enname.'</div>';
	
	$childs = MenuLink::where("menu_id",$menuId)->where("parent_id",$parent->id)->orderBy("sort_order","asc")->get();
	
	
	if(!$childs->isEmpty()){
		echo '<ol class="dd-list">';
		foreach($childs as $child){
			echo getTree($child,$menuId);
		}
		echo "</ol>";
	}else{
		echo "</li>";
	}
 }
?>
				
					<div>
						<div class="margin-bottom-10" id="nestable_list_menu">							
							<div class="row">
								<div class="col-md-1" style="padding-left: 0px;">
									<button id="saveMenu1" type="button" class="btn green demo-loading-btn" data-loading-text="saving..."><i class="fa fa-save"></i> Save Menu</button>
								</div>
								
								<div class="col-md-7 col-md-offset-4" >
									<button type="button" class="btn green" data-action="expand-all"><i class="fa fa-folder-open-o"></i>expand all </button>
									<button type="button" class="btn green" data-action="collapse-all"><i class="fa fa-folder-o"></i>collapse all </button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs">
		                                <li class="active ">
		                                    <a href="#tab_5" data-toggle="tab" aria-expanded="true"> 
		                                     	<img src="{{asset('assets/admin/img/flags/gb.png')}}">
		                                    	 English
		                                    </a>
		                                </li>
		                               <li>
		                                   <a href="#tab_6" data-toggle="tab" aria-expanded="true"> 
		                                   		 <img src="{{asset('assets/admin/img/flags/kw.png')}}">
		                                        عربي 
		                                    </a>
		                               </li>
		                           </ul>
		                           <div class="tab-content">
		                                <div class="tab-pane fade active in" id="tab_5">
		                                	<div class="form-group">
												<label>menu name </label>
												<input type="text" id="menuNameEdit"  value="{{$menuName}}" class="form-control required"/>											
											</div>
	                                	</div>
	                                	<div class="tab-pane fade" id="tab_6">
	                                		<div class="form-group">
												<label>menu name</label>
												<input type="text" id="ar_menuNameEdit" value="{{$menu->name_ar}}" class="form-control"/>
											</div>
	                                	</div>
	                               </div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="menu_id" value="{{$menuId}}"/>
					<div  id="reloadrow">
						<div class="dd" id="nestable_list_3">
							<ol class="dd-list">
								@foreach($parentLinks as $parentLink)
									{!!getTree($parentLink,$menuId)!!}
								@endforeach
							</ol>
						</div>
						
					</div>
				<input type="hidden" id="nestable2-output" value=""/>
				<div class="form-actions">
					 <br/>
						<span style="float: right;"><a id="deleteMenu" >delete menu</a></span>
						<button id="saveMenu" type="button" data-loading-text="saving..." class="btn green demo-loading-btn" style="float:left;"><i class="fa fa-save"></i> Save Menu</button>
							
							
					<div class="row">
						
					</div>
						
					</div>	