
 <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('teachers/create');
		$btn='<i class="fa fa-plus"></i>' . " Add ";
	}else {
		$url = url('/teachers/profile');
		$btn='<i class="fa fa-edit"></i>' ." Edit ";
	}
?>
 <div class="portlet-body"> 
 	   	    
	<form method="post"  id="form_teacher" name="form_teacher" class="form-horizontal form-row-seperated" action="{{ $url }}" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" name="id" value="{{$method=='edit' ? $teacher->id:"0"}}">
		
		<div class="form-actions left" style="float: right;">
	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$btn!!}</button>
			<button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('teachers')}}'"><i class="fa fa-reply"></i> cancel</button>
    	</div>	
    	<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_user" data-toggle="tab">
					<i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
					user</a>
			</li>
		    <li>
		        <a href="#tab_public1" data-toggle="tab">
		           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
		        public</a>
		    </li>

		    <li>
                <a href="#tab_social" data-toggle="tab"> Social Media 
                	<span class="badge badge-success"> {{$method=="edit"?$teacher->socials->count():0}} </span></a>
            </li>  
		</ul>
		<div  class="tab-content mar-top">
			<div id="tab_user" class="tab-pane fade active in">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading"></div>
							@include("admin.users._form_fields",array("user"=>$teacher->user,"page"=>"front"))
						</div>
					</div>
				</div>
			</div>
		    <div id="tab_public1" class="tab-pane fade">
				<div class="row">            
	                <div class="panel">
	                	 <div class="panel-heading">
	
	                    </div>
				    	<div class="form-body">
    					<ul class="nav nav-tabs">
					        <li class="active">
					            <a href="#tab_1" data-toggle="tab" aria-expanded="true"> 
					              <img src="{{asset('assets/admin/img/flags/kw.png')}}">
					                 Arabic
					            </a>
					        </li>
					       <li>
					           <a href="#tab_2" data-toggle="tab" aria-expanded="true"> 
					            	<img src="{{asset('assets/admin/img/flags/gb.png')}}">
					            	 English
					            </a>
					       </li>
					   </ul>
					   <div class="tab-content">
					   	<div class="tab-pane fade active in" id="tab_1">
					   		<div class="col-lg-12">
					        	<div class="panel">
					        		<div class="panel-body">

								    	<div class="form-group">
											<label class="col-md-2 control-label">job <span style="color:red;">*</span></label>
											<div class="col-md-10">
												<input type="text" id="ar_job" name="ar_job" value="{{($method=='edit')?$teacher->teacher_trans('ar')->job:null}}" class="form-control"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">about</label>
											<div class="col-md-10">
												<textarea cols="60"  name="ar_about"  class="form-control">{{($method=='edit')?$teacher->teacher_trans('ar')->about:null}}</textarea>
											</div>
										</div>

								    </div>
					        	</div>
					       </div>
					     </div>
					     <div class="tab-pane fade" id="tab_2">
				        	<div class="col-lg-12">
				                <div class="panel">
				                	<div class="panel-body">
				                		<?php
							        		$en_teacher="";
											if($method=="edit")
							        			$en_teacher = $teacher->teacher_trans('en');
							        	?>
								    	<div class="form-group">
											<label class="col-md-2 control-label">job <span style="color:red;">*</span></label>
											<div class="col-md-10">
												<input type="text" id="en_job" name="en_job" value="{{(!empty($en_teacher))?$en_teacher->job:null}}" class="form-control"/>
											</div>
										</div>

											<div class="form-group">
												<label class="col-md-2 control-label">about</label>
												<div class="col-md-10">
													<textarea cols="60"  name="en_about"  class="form-control">{{(!empty($en_teacher))?$en_teacher->about:null}}</textarea>
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

           <div class="tab-pane" id="tab_social">
	            <div class="row">
	        		<div class="panel">
	        			<div class="panel-heading">
	
	                    </div>
	        			<div class="panel-body">
	            			@include("admin.teachers.tabs._social")  
	           			</div>
	               	</div>
	            </div>
	        </div>  
        </div>    
     </form>
    </div>