  <?php
  ini_set('display_errors', 'on'); 
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/orders/create/');
		$btn=trans('admin.add');
	}else {
		//admin/orders/edit/'.$order->id'
		$url = url('login');
		$btn="edit";
	}


	
?>

 <div class="portlet-body">
	 <div id="loadmodel_category" class="modal fade in" role="dialog"  style="display:none; padding-right: 17px;">
		 <div class="modal-dialog">
			 <div class="modal-content">
				 <div class="modal-body">
					 <img src="{{asset('assets/admin/img/ajax-loading.gif')}}" alt="" class="loading">
					 <span> &nbsp;&nbsp;Loading... </span>
				 </div>
			 </div>
		 </div>
	 </div>
 			    
	<form action="{{$url}}" method="post" id="orders-form" class="form-horizontal form-row-seperated" enctype="multipart/form-data">
	
		{!!csrf_field()!!}
		<input type="hidden" name="methodForm" value="{{$method}}"/>
		<input type="hidden" id="id" value="{{($method=='edit')?$order->id:0}}"/>
		
		<div class="row">
			<div class="form-actions left" style="float: right;">
				 <a class="btn btn-info printOrder" >Print</a>
		        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
		            <i class="fa fa-check"></i>Save</button>
		        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/orders/')}}'"><i class="fa fa-reply"></i> Cancel</button>

		    </div>	
		</div>						
		
		<ul class="nav nav-tabs">
		    <li class="active">
		        <a href="#tab1" data-toggle="tab">
		           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
					Details
				</a>
		    </li>
			<li>
				<a href="#tab3" data-toggle="tab">
				<i class="livicon" data-name="gift" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
				   Print invoice</a>
			</li>
		</ul>
		<div class="tab-content mar-top">
		    <div id="tab1" class="tab-pane fade active in">										
				<div class="row">
		            <div class="col-lg-12">
		                <div class="panel">
		                   <div class="panel-body" style="margin-top: 20px;">
		                    	@include("admin.orders.tabs._details")
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div id="tab3" class="tab-pane fade">
				<div class="row">
					<div class="panel">
						<div class="panel-body" style="margin-top: 20px;">
							@include("admin.orders._report_shipping")
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>

  <div class="modal fade" id="modal-2">
	  <div class="modal-dialog">
		  <div class="modal-content" >
			  <div class="modal-header">
				  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				  <h3 id="myModalLabel1">Add payment</h3>
			  </div>
			  <div class="panel-body">
				  <form class="form-horizontal" id="form_payment" name="form_payment" novalidate>
					  {{csrf_field()}}
					  <input type="hidden" id="url_payment" value="{{url('admin/orders/create-payment')}}">
					  <input type="hidden" name="order_id" value="{{$order->id}}">
					  <div class="modal-body">
						  <div class="form-group">
							  <label class="control-label col-md-3">Total</label>
							  <div class="col-md-6">
								  <input type="text" name="total" class="form-control touchspin_1" value="0"/>
							  </div>
						  </div>
						  <div class="form-group">
							  <label class="control-label col-md-3">Paid</label>
							  <div class="col-md-6">
								  <input type="checkbox" id="paid" name="paid">Paid
							  </div>
						  </div>
					  </div>
					  <div class="modal-footer">
						  <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="saving...">Save</button>
						  <button aria-hidden="true" data-dismiss="modal" class="btn">Cancel </button>
					  </div>
				  </form >
			  </div>
		  </div>
	  </div>
  </div>