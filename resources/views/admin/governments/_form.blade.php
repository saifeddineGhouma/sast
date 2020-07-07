<div class="modal fade" id="modal-2">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">add government</h3>
            </div>
			<form class="form-horizontal" id="form_government" name="form_government" novalidate>
				{{csrf_field()}}
			<input type="hidden" id="url" value="{{url('admin/governments/create')}}">
			<input type="hidden" id="government_id" name="government_id" value="0">
            <div class="modal-body">
            	
            	<div class="form-group">
		            <label class="control-label  col-md-3"> country<span style="color:red;">*</span></label>
		            <div  class="col-md-6">
		                <select  id="country_id" name="country_id" class="form-control">
		                     <option value=""></option>
		                    @foreach($countries as $country)
		                    	<option value= "{{$country->id}}"  >{{$country->country_trans("en")->name}}</option>
		                    @endforeach
		                </select>
		            </div>
		        </div>
            	
            	<ul class="nav nav-tabs">
		            <li class="active">
		                <a href="#tab_1" data-toggle="tab" aria-expanded="true"> 
		                  <img src="{{asset('assets/admin/img/flags/gb.png')}}">
		                    English 
		                </a>
		            </li>
		           <li>
		               <a href="#tab_2" data-toggle="tab" aria-expanded="true"> 
		                	<img src="{{asset('assets/admin/img/flags/kw.png')}}">
		                	 Arabic
		                </a>
		           </li>
		       </ul>
		        <div class="tab-content">
		            <div class="tab-pane fade active in" id="tab_1">
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">name<span style="color:red;">*</span></label>
					            <div class="col-md-6">
					                <input type="text" id="en_name" name="en_name" class="form-control"/>
					            </div>
					        </div>
		            	</div>
		            </div>
		            <div class="tab-pane fade" id="tab_2">
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">name</label>
					            <div class="col-md-6">
					                <input type="text" id="ar_name" name="ar_name" class="form-control"/>
					            </div>
					        </div>
		            	</div>
		            </div>
		        </div>
		        	
			   	
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="saving...">save</button>
				<button aria-hidden="true" data-dismiss="modal" class="btn">cancel </button>
            </div>
			</form >
        </div>
    </div>
</div>
