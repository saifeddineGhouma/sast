<div class="panel-body">
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
                	 <div class="panel-heading"></div>
                    <div class="panel-body">
			        	<div class="form-group">
				    		<label class="col-md-2 control-label">title <span style="color:red;">*</span></label>
				    		<div class="col-md-10">
				    			<input type="text" id="ar_title" name="ar_title" class="form-control" value="{{($method=='edit')?$testimonial->testimonial_trans('ar')->title:null}}">
				    		</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">name</label>
				    		<div class="col-md-10">
				    			<input type="text" id="ar_name" name="ar_name" class="form-control" value="{{($method=='edit')?$testimonial->testimonial_trans('ar')->name:null}}">
				    		</div>
				    	</div>
			        	<div class="form-group">
			        		<label class="col-md-2 control-label">description</label>   
			        		 <div class="col-md-10">
			                   		<textarea cols="60"  name="ar_description"  class="form-control" maxlength="160">{{($method=='edit')?$testimonial->testimonial_trans('ar')->description:null}} </textarea>                                    
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
			        		$en_testimonial="";
							if($method=="edit")
			        			$en_testimonial = $testimonial->testimonial_trans('en');
			        	?>
			        	
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">title </label>
				    		<div class="col-md-10">
				    			<input type="text" name="en_title" class="form-control" value="{{(!empty($en_testimonial))?$en_testimonial->title:null}}">
				    		</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">name </label>
				    		<div class="col-md-10">
				    			<input type="text" name="en_name" class="form-control" value="{{(!empty($en_testimonial))?$en_testimonial->name:null}}">
				    		</div>
				    	</div>				    	
			        	<div class="form-group">
			        		<label class="col-md-2 control-label">description</label>   
			        		 <div class="col-md-10">
			                   		<textarea cols="60" name="en_description" class="form-control" maxlength="160">{{(!empty($en_testimonial))?$en_testimonial->description:null}} </textarea>                                    
			                  </div>
			        	</div>			        	
				    </div>
				 </div>
			</div>
        </div>        
    </div>
	
</div>