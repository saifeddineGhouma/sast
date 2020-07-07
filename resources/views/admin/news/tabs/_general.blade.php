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
				    			<input type="text" id="ar_title" name="ar_title" class="form-control" value="{{($method=='edit')?$news->news_trans('ar')->title:null}}">
				    		</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
				    		<div class="col-md-10">
				    			<input type="text" id="ar_slug" name="ar_slug" class="form-control slug" value="{{($method=='edit')?$news->news_trans('ar')->slug:null}}">
				    		</div>
				    	</div>
			        	<div class="form-group">
			        		<label class="col-md-2 control-label">short description</label>   
			        		 <div class="col-md-10">
			                   		<textarea cols="60"  name="ar_short_description"  class="form-control" maxlength="160">{{($method=='edit')?$news->news_trans('ar')->short_description:null}} </textarea>                                    
			                  </div>
			        	</div>
			        	<div class="form-group">
							<label class="col-md-2 control-label">content</label>
							<div class="col-md-10">									
						        <div class="bootstrap-admin-panel-content">
						            <textarea id="tinymce_full_ar" name="ar_content" rows="15">{{($method=='edit')?$news->news_trans("ar")->content:null}}</textarea>
						        </div>
							</div>
						</div> 
			        	<div class="form-group">
				    		<label class="col-md-2 control-label">meta title</label>
				    		<div class="col-md-10">
				            	<input type="text"  name="ar_meta_title" class="form-control maxlength-handler" maxlength="60"
				            		value="{{($method=='edit')?$news->news_trans('ar')->meta_title:null}}">
				          		<span class="help-block"> maxlength 60 character</span>  
				          	</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">meta keyword</label>
				    		 <div class="col-md-10">
				             	<input type="text" name="ar_meta_keyword" class="form-control" data-role="tagsinput" value="{{($method=='edit')?$news->news_trans('ar')->meta_keyword:null}}"> 
				             </div>
				    	</div>
				    	
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">meta description</label>   
				    		 <div class="col-md-10">
				               		<textarea cols="60"  name="ar_meta_description"  class="form-control maxlength-handler" maxlength="160">{{($method=='edit')?$news->news_trans('ar')->meta_description:null}} </textarea>
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
			        		$en_news="";
							if($method=="edit")
			        			$en_news = $news->news_trans('en');
			        	?>
			        	
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">title </label>
				    		<div class="col-md-10">
				    			<input type="text" name="en_title" class="form-control" value="{{(!empty($en_news))?$en_news->title:null}}">
				    		</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
				    		<div class="col-md-10">
				    			<input type="text" id="en_slug" name="en_slug" class="form-control slug" value="{{(!empty($en_news))?$en_news->slug:null}}">
				    		</div>
				    	</div>
			        	<div class="form-group">
			        		<label class="col-md-2 control-label">short description</label>   
			        		 <div class="col-md-10">
			                   		<textarea cols="60"  name="en_short_description"  class="form-control" maxlength="160">{{(!empty($en_news))?$en_news->short_description:null}} </textarea>                                    
			                  </div>
			        	</div>
			        	<div class="form-group">
							<label class="col-md-2 control-label">content</label>
							<div class="col-md-10">									
						        <div class="bootstrap-admin-panel-content">
						            <textarea id="tinymce_full_en" name="en_content" rows="15">{{(!empty($en_news))?$en_news->content:null}}</textarea>
						        </div>
							</div>
						</div> 
			        	<div class="form-group">
				    		<label class="col-md-2 control-label">meta title</label>
				    		<div class="col-md-10">
				            	<input type="text"  name="en_meta_title" class="form-control maxlength-handler" maxlength="60"
				            		value="{{(!empty($en_news))?$en_news->meta_title:null}}">
				          		<span class="help-block"> maxlength 60 character</span>  
				          	</div>
				    	</div>
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">meta keyword</label>
				    		 <div class="col-md-10">
				             	<input type="text" name="en_meta_keyword" class="form-control" data-role="tagsinput" value="{{(!empty($en_news))?$en_news->meta_keyword:null}}"> 
				             </div>
				    	</div>
				    	
				    	<div class="form-group">
				    		<label class="col-md-2 control-label">meta description</label>   
				    		 <div class="col-md-10">
				               		<textarea cols="60"  name="en_meta_description"  class="form-control maxlength-handler" maxlength="160">{{(!empty($en_news))?$en_news->meta_description:null}} </textarea>
				               		<span class="help-block"> maxlength 160 character </span>                                      
				              </div>
				    	</div>
				    </div>
				 </div>
			</div>
        </div>
    </div>
	
</div>