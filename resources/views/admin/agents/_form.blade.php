<div class="modal fade" id="modal-2">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">add agent</h3>
            </div>
			<form class="form-horizontal" id="form_agent" name="form_government" novalidate>
				{{csrf_field()}}
			<input type="hidden" id="url" value="{{url('admin/agents/create')}}">
			<input type="hidden" id="agent_id" name="agent_id" value="0">
            <div class="modal-body">
            	
            	<div class="form-group">
		            <label class="control-label  col-md-3"> country<span style="color:red;">*</span></label>
		            <div  class="col-md-6">
		                <select  id="country_id" name="country_id" class="form-control">

		                    @foreach($countries as $country)
		                    	<option value= "{{$country->id}}"  >{{$country->country_trans("en")->name}}</option>
		                    @endforeach
		                </select>
		            </div>
		        </div>

				<div class="form-group">
					<label class="control-label col-md-3">name<span style="color:red;">*</span></label>
					<div class="col-md-6">
						<input type="text" id="name" name="name" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">mobile</label>
					<div class="col-md-6">
						<input type="text" id="mobile" name="mobile" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">email</label>
					<div class="col-md-6">
						<input type="text" id="email" name="email" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">address</label>
					<div class="col-md-6">
						<textarea id="address" name="address" class="form-control"></textarea>
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
