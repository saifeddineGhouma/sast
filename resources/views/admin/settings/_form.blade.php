
 <?php
	$url="";
	$btn = "";
	
	
	$url = url('admin/settings/edit');
	$btn="تعديل";

?>

<div class="panel-body ">
 	  	    
	<form method="post" action="{{$url}}"  id="form_settings" name="form_settings" class="form-horizontal form-row-seperated" enctype="multipart/form-data">
		 {{csrf_field()}}
		<input type="hidden" id="url" value="{{$url}}">
		
		<div class="form-actions left" style="float: right;">
	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
	            <i class="fa fa-check"></i> Save</button>
	        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin')}}'"><i class="fa fa-reply"></i> Cancel</button>
	    </div>	
   
                     
		<div class="tabbable-bordered">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_general" data-toggle="tab"> Public </a>
                </li>
                <li>
                    <a href="#tab_data" data-toggle="tab"> Data </a>
                </li>
                <li>
                    <a href="#tab_slider" data-toggle="tab"> Slider 
                    	<span class="badge badge-success"> {{($method=="edit")?$setting->sliderimages->count():0}} </span></a>
                </li>
                <li>
                    <a href="#tab_social" data-toggle="tab"> Social Media 
                    	<span class="badge badge-success"> {{$setting->socials->count()}} </span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_general">
                	<div class="row">
			            <div class="col-lg-12">
			                <div class="panel">
			                	 <div class="panel-heading">
			
			                    </div>
			                    <div class="panel-body">
                    				@include("admin.settings.tabs._general")
                    			</div>
                    		</div>
                    	</div>
                   </div>
                </div>
                 <div class="tab-pane" id="tab_data">
                    <div class="row">
		        		<div class="panel">
		        			<div class="panel-heading">
		
		                    </div>
		        			<div class="panel-body">
                       			@include("admin.settings.tabs._data")     
                       		</div>
                       	</div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_slider">
                    <div class="row">
		        		<div class="panel">
		        			<div class="panel-heading">
		
		                    </div>
		        			<div class="panel-body">
                       			@include("admin.settings.tabs._slider")     
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
                    			@include("admin.settings.tabs._social")  
                   			</div>
                       	</div>
                    </div>
                </div>
                 
            </div>
           
        </div>   
                   
     </form>
    </div>