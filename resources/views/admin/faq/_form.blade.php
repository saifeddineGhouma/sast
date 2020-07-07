<div class="modal fade" id="modal-2">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">add faq</h3>
            </div>
			<form class="form-horizontal" id="form_faq" name="form_country" novalidate>
				{{csrf_field()}}
			<input type="hidden" id="url" value="{{url('admin/faq/create')}}">
			<input type="hidden" id="faq_id" name="faq_id" value="0">
            <div class="modal-body">
            	<div class="form-group">
		            <label class="control-label col-md-3">sort order</label>
		            <div class="col-md-6">
		                <input type="text" id="sort_order" name="sort_order" class="form-control"/>
		            </div>
		        </div>

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
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">question</label>
					            <div class="col-md-6">
					                <textarea type="text" id="ar_question" name="ar_question" class="form-control"></textarea>
					            </div>
					        </div>
		            	</div>
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">answer</label>
					            <div class="col-md-6">
					                <textarea type="text" id="ar_answer" name="ar_answer" class="form-control"></textarea>
					            </div>
					        </div>
		            	</div>
		            </div>
		            <div class="tab-pane fade" id="tab_2">
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">question</label>
					            <div class="col-md-6">
					                <textarea type="text" id="en_question" name="en_question" class="form-control"></textarea>
					            </div>
					        </div>
		            	</div>
		            	<div class="row">
		            		<div class="form-group">
					            <label class="control-label col-md-3">answer</label>
					            <div class="col-md-6">
					                <textarea type="text" id="en_answer" name="en_answer" class="form-control"></textarea>
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
