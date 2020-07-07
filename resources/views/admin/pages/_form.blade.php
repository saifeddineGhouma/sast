
<div class="panel-body ">
	<!-- BEGIN FORM-->
	<?php
	$url="";
		if($method == 'add')
			$url = url('admin/pages/create');
		else {
			$url = url('admin/pages/edit/'.$page->id);
		}
	?>
	<form action="{{$url}}" method="post" id="pages-form" class="form-horizontal form-row-seperated" enctype='multipart/form-data'>
	
		{!!csrf_field()!!}
		<input type="hidden" name="methodForm" value="{{$method}}"/>
		<input type="hidden" name="pageid" value="{{($method=='edit')?$page->id:0}}"/>
	<div class="form-actions left" style="float: right;">
        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
            <i class="fa fa-check"></i> Save</button>
        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{URL::previous()}}'"><i class="fa fa-reply"></i> Cancel</button>
    </div>	
	<ul class="nav nav-tabs">
	    <li class="active">
	        <a href="#tab1" data-toggle="tab">
	           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
	        public</a>
	    </li>
	    <li>
	        <a href="#tab2" data-toggle="tab">
	     <i class="livicon" data-name="gift" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
	       data</a>
	    </li>  
	</ul>
	<div  class="tab-content mar-top">
	    <div id="tab1" class="tab-pane fade active in">										
			<div class="row">
            <div class="col-lg-12">
                <div class="panel">
                	 <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                    	
							<ul class="nav nav-tabs">
						        <li class="active">
									<a href="#tab_2" data-toggle="tab" aria-expanded="true">
										<img src="{{asset('assets/admin/img/flags/kw.png')}}">
										Arabic
									</a>
						        </li>
						       <li>
								   <a href="#tab_1" data-toggle="tab" aria-expanded="true">
									   <img src="{{asset('assets/admin/img/flags/gb.png')}}">
									   English
								   </a>
						       </li>
						   </ul>
						    <div class="tab-content">
						        <div class="tab-pane fade active in" id="tab_1">
						        	<div class="col-lg-12">
						                <div class="panel">
						                	 <div class="panel-heading">
						
						                    </div>
						                    <div class="panel-body">
									        	<div class="form-group">
										    		<label class="col-md-2 control-label">title <span style="color:red;">*</span></label>
										    		<div class="col-md-10">
										    			<input type="text" id="en_name" name="en_title" class="form-control" value="{{($method=='edit')?$page->page_trans('en')->title:null}}">
										    		</div>
										    	</div>
										    	<div class="form-group">
													<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
													<div class="col-md-10">
														<input type="text" id="en_slug" name="en_slug" value="{{($method=='edit')?$page->page_trans('en')->slug:null}}" class="form-control slug"/>
													</div>
												</div> 												
										    	
										    	<div class="form-group">
													<label class="col-md-2 control-label">content</label>
													<div class="col-md-10">									
												        <div class="bootstrap-admin-panel-content">
												            <textarea id="tinymce_full_en" rows="15">{{($method=='edit')?$page->page_trans("en")->content:null}}</textarea>
												            <input type="hidden" name="en_content"/>
												        </div>
													</div>
												</div> 
			                
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta title</label>
										    		<div class="col-md-10">
										            	<input type="text"  name="en_meta_title" class="form-control maxlength-handler" maxlength="60"
										            		value="{{($method=='edit')?$page->page_trans('en')->meta_title:null}}">
										          		<span class="help-block"> maxlength 60 character</span>  
										          	</div>
										    	</div>
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta keyword</label>
										    		 <div class="col-md-10">
										             	<input type="text" name="en_meta_keyword" class="form-control" data-role="tagsinput" value="{{($method=='edit')?$page->page_trans('en')->meta_keyword:null}}"> 
										             </div>
										    	</div>
										    	
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta description</label>
										    		 <div class="col-md-10">
										               		<textarea cols="60"  name="en_meta_description"  class="form-control maxlength-handler" maxlength="160">{{($method=='edit')?$page->page_trans('en')->meta_description:null}} </textarea>
										               		<span class="help-block"> maxlength 160 character </span>                                      
										              </div>
										    	</div>
										    </div>
										  </div>
									</div>
						        </div>
						        <div class="tab-pane fade" id="tab_2">
						        	<div class="col-lg-12">
						                <div class="panel">
						                	 <div class="panel-heading">
						
						                    </div>
						                    <div class="panel-body">
									        	<?php
									        		$ar_page="";
													if($method=="edit")
									        			$ar_page = $page->page_trans('ar');
									        	?>
									        	<div class="form-group">
										    		<label class="col-md-2 control-label">title</label>
										    		<div class="col-md-10">
										    			<input type="text" id="ar_name" name="ar_title" class="form-control" value="{{(!empty($ar_page))?$ar_page->title:null}}">
										    		</div>
										    	</div>										    	
										    	<div class="form-group">
													<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
													<div class="col-md-10">
														<input type="text" id="ar_slug" name="ar_slug" value="{{(!empty($ar_page))?$ar_page->slug:null}}" class="form-control slug"/>
													</div>
												</div>
										    	<div class="form-group">
													<label class="col-md-2 control-label">content</label>
													<div class="col-md-10">									
												        <div class="bootstrap-admin-panel-content">
												            <textarea id="tinymce_full_ar" rows="15">{{(!empty($ar_page))?$ar_page->content:null}}</textarea>
												            <input type="hidden" name="ar_content"/>
												        </div>
													</div>
												</div> 
			                
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta title</label>
										    		<div class="col-md-10">
										            	<input type="text"  name="ar_meta_title" class="form-control maxlength-handler" maxlength="60"
										            		value="{{(!empty($ar_page))?$ar_page->meta_title:null}}">
										          		<span class="help-block"> maxlength 60 character</span>  
										          	</div>
										    	</div>
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta keyword</label>
										    		 <div class="col-md-10">
										             	<input type="text" name="ar_meta_keyword" class="form-control" data-role="tagsinput" value="{{(!empty($ar_page))?$ar_page->meta_keyword:null}}"> 
										             </div>
										    	</div>
										    	
										    	<div class="form-group">
										    		<label class="col-md-2 control-label">meta description</label>
										    		 <div class="col-md-10">
										               		<textarea cols="60"  name="ar_meta_description"  class="form-control maxlength-handler" maxlength="160">{{(!empty($ar_page))?$ar_page->meta_description:null}} </textarea>
										               		<span class="help-block"> maxlength 160 character </span>                                      
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
			</div>
		</div>
		<div id="tab2" class="tab-pane fade">
        	<div class="row">
        		<div class="panel">
        			<div class="panel-heading">

                    </div>
        			<div class="panel-body">
		        		
						<div class="form-group">
							<label class="col-md-2 control-label">font</label>
							<div class="col-md-10">
								<select class="form-control" name="font">
									@foreach($fontArray as $key=>$value)
					          			<option value="{{$key}}" {{($method=='edit'&&$key==$page->font)?"selected":null}}>{{$value}}</option>
					          		@endforeach
								</select>								
							</div>
						</div> 
						<div class="form-group">
							<label class="col-md-2 control-label">نشط</label>
							<div class="col-md-10">
								<input type="checkbox" name="active" class="make-switch" {{$method=="add"?"checked":null}} {{ (isset($page->active) && $page->active)?'checked':'' }}  data-on-text="Yes" data-off-text="No">															
							</div>
						</div>	
					</div>
				</div>
        	</div>
        </div>								
	</div>
	</form>
	<!-- END FORM-->
</div>