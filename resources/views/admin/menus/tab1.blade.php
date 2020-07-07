<div class="row">
	<div class="col-md-12">
			<div id="errorDiv" style="display: none;">
                	<div class="alert alert-danger">
                		<ul id="errorul">
                			
                		</ul>
                	</div>
               </div>
		
	</div>
</div>
<?php
	if(!empty(App\MenuLink::orderBy('id','desc')->first()))
		$id = App\MenuLink::orderBy('id','desc')->first()->id+1;
	else 
		$id = 1;
?>
<input type="hidden" id="linkId" value="{{$id}}"/>				
<!-- Begin Choose Menu-->
<div class="row">
	<div class="col-md-12">
		
		<!-- static -->
		<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
			<div class="modal-body">				
				<div class="form-group">
					<label >menu name <span class="required">* </span></label>
					<input type="text" id="menuName"  placeholder="" value="" class="form-control"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">cancel</button>
				<button type="button" id="menuBtn" data-loading-text="adding..." class="demo-loading-btn btn blue">Add Menu</button>
			</div>
		</div>					
									
		<div class="note note-success">
			<div id="reloadMenu">
				<p>
					<span style="padding:3px;"> chose menu to edit </span> 
					<span style="margin-left: 5px;">
						<select class="bs-select form-control1 input-medium" id="menuSelect" data-style="btn-primary">
								@foreach($mainMenus as $mainMenu)
									<option value="{{$mainMenu->id}}">{{$mainMenu->name}}</option>
								@endforeach
									
						</select>
					</span>
					<span style="padding:3px;">or  <a class=" green" data-target="#static" data-toggle="modal"> create new menu </a></span>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- End Choose Menu-->

<div class="row">
	
	<!-- Begin Right Panel-->
	<div class="col-md-4">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>types of links
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="panel-group accordion scrollable" id="accordion2">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle accordion-toggle-styled " data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
							sub menus </a>
							</h4>
						</div>
						<div id="collapse_2_1" class="panel-collapse in">
							<div class="panel-body">
								<ul class="nav nav-tabs">
	                                <li class="active ">
	                                    <a href="#tab_1" data-toggle="tab" aria-expanded="true"> 
	                                     
	                                    	 English
	                                    </a>
	                                </li>
	                               <li>
	                                   <a href="#tab_2" data-toggle="tab" aria-expanded="true"> 
	                                   	
	                                        عربي 
	                                    </a>
	                               </li>
	                           </ul>
	                            <div class="tab-content">
	                                <div class="tab-pane fade active in" id="tab_1">
	                                	<div class="form-group">
											<label>sub menu name<span class="required">* </span></label>
											<input type="text" id="en_submenu" placeholder="" value="" class="form-control"/>
										</div>
                                	</div>
                                	<div class="tab-pane fade" id="tab_2">
                                		<div class="form-group">
											<label>sub menu name</label>
											<input type="text" id="ar_submenu" placeholder="" value="" class="form-control"/>
										</div>                                		
                                	</div>
                               </div>
                                	
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button id="addSubMenu" type="button" class="btn default" >Add To Menu</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2">
							pages </a>
							</h4>
						</div>
						<div id="collapse_2_2" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="form-body" id="pages">
								@foreach($pages as $page)
									<?php $ar_name = "";
										if(!empty($page->page_trans('ar')))
											$ar_name = $page->page_trans('ar')->title;
									?>
									<div class="form-group">
										<input type="checkbox" id="page_{{$page->id}}" ar_element="{{$ar_name}}" en_element="{{$page->page_trans('en')->title}}" name="page">
										<label>{{$page->page_trans("en")->title}}</label>
									</div>
								@endforeach
								<a  id="checkall" >check all</a>
								</div>
								
								<div class="form-body">
									<div class="form-group">
										<input type="checkbox" id="open-window-page" name="open-window-page">
										<label>open in new window</label>
									</div>
								</div>
								
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button id="addPage" type="button" class="btn default" >Add To Menu</button>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3">
							customized links </a>
							</h4>
						</div>
						<div id="collapse_2_3" class="panel-collapse collapse">
							<div class="panel-body">
								
								<ul class="nav nav-tabs">
	                                <li class="active ">
	                                    <a href="#tab_3" data-toggle="tab" aria-expanded="true"> 
	                                     	
	                                    	 English
	                                    </a>
	                                </li>
	                               <li>
	                                   <a href="#tab_4" data-toggle="tab" aria-expanded="true"> 
	                                   		
	                                        عربي 
	                                    </a>
	                               </li>
	                           </ul>
	                            <div class="tab-content">
	                                <div class="tab-pane fade active in" id="tab_3">
	                                	<div class="form-group">
											<label >link text<span class="required">* </span></label>
											<input type="text" id="en_linktxt" name="en_linktxt" placeholder="" value="" class="form-control"/>											
										</div>
                                	</div>
                                	<div class="tab-pane fade" id="tab_4">
                                		<div class="form-group">
											<label>link text</label>
											<input type="text" id="ar_linktxt" name="ar_linktxt" placeholder="" value="" class="form-control"/>
										</div>
                                	</div>
                               </div>
                               
								<div class="form-group">
									<label >link<span class="required">* </span></label>
									<input type="text" id="link" placeholder="" value="" class="form-control"/>
								</div>
								
								<div class="form-body">
									<div class="form-group">
										<input type="checkbox" id="open-window" name="open-window">
										<label>open in new window</label>
									</div>
								</div>
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button id="addLink" type="button" class="btn default" >Add To Menu</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_4">
							 design pages </a>
							</h4>
						</div>
						<div id="collapse_2_4" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="form-body" id="design_pages">
									<div class="form-group">
										<input type="checkbox" id="mainPage" ar_element="الرئيسية" en_element="Home" name="design">
										<label>Home page</label>
									</div>
									<div class="form-group">
										<input type="checkbox" id="contactPage" ar_element="اتصل بنا" en_element="Contact" name="design">
										<label>Contact page</label>
									</div>
									<div class="form-group">
										<input type="checkbox" id="coursesPage" ar_element="الدورات" en_element="courses" name="design">
										<label>Courses</label>
									</div>
									<div class="form-group">
										<input type="checkbox" id="booksPage" ar_element="الكتب" en_element="Books" name="design">
										<label>Books</label>
									</div>
									<div class="form-group">
										<input type="checkbox" id="graduatesPage" ar_element="الخريجون" en_element="Checkout" name="design">
										<label>Graduates</label>
									</div>

									<div class="form-group">
										<input type="checkbox" id="faqPage" ar_element="الأسئلة المتكررة" en_element="Faq" name="design">
										<label>Faq</label>
									</div>
									<div class="form-group">
										<input type="checkbox" id="newsPage" ar_element="أخبارنا" en_element="News" name="design">
										<label>News</label>
									</div>
									<a  id="checkall_design" >check all</a>
								</div>

								<div class="form-body">
									<div class="form-group">
										<input type="checkbox" id="open-window-design" name="open-window-design">
										<label>open in new window</label>
									</div>
								</div>


								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button id="addDesign" type="button" class="btn default" >Add To Menu</button>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- End Right Panel-->
	
	<!-- Begin Left Panel-->
	<div class="col-md-8">
		
		<div class="row">
			<div class="portlet box blue" style="margin-left: 10px;">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-comments"></i>Menu Links
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse">
						</a>
						<a href="javascript:;" class="reload">
						</a>											
					</div>
				</div>

					
				<!-- links-->
				<div class="portlet-body">
					
						<div id="linksChildList"></div>
					<meta name="csrf-token" content="{{ csrf_token() }}">
				</div>

				
			</div>
		</div>
	</div>
	<!-- End Left Panel-->
	
</div>






