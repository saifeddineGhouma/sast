
		<input type="hidden" id="id" name="id" value="{{$method=='edit' ? $book->id:"0"}}">
		
		<div class="form-actions left" style="float: right;">
	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
	            <i class="fa fa-check"></i> Save</button>
	        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/'.$table_name)}}'"><i class="fa fa-reply"></i> Cancel</button>
	    </div>	
	    
	    
	    <div class="tabbable-bordered">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_general" data-toggle="tab"> Public </a>
                </li>
                <li>
                    <a href="#tab_data" data-toggle="tab"> Data </a>
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
                    				@include("admin.".$table_name.".tabs._general")
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
                       			@include("admin.".$table_name.".tabs._data")
                       		</div>
                       	</div>
                    </div>
                </div>                 
            </div>
           
        </div>