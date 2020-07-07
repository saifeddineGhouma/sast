  <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/orders/create/');
		$btn="add";
	}else {
		$url = url('admin/book-orders/edit/'.$order->id);
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
				 <a class="btn btn-info printOrder" >print</a>
		        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
		            <i class="fa fa-check"></i>save</button>
		        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/book-orders/')}}'"><i class="fa fa-reply"></i> cancel</button>

		    </div>	
		</div>						
		
		<ul class="nav nav-tabs">
		    <li class="active">
		        <a href="#tab1" data-toggle="tab">
		           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
		        details</a>
		    </li>
			<li>
				<a href="#tab3" data-toggle="tab">
				<i class="livicon" data-name="gift" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
				   print invoice</a>
			</li>
		</ul>
		<div class="tab-content mar-top">
		    <div id="tab1" class="tab-pane fade active in">										
				<div class="row">
		            <div class="col-lg-12">
		                <div class="panel">
		                   <div class="panel-body" style="margin-top: 20px;">
		                    	@include("admin.bookorders.tabs._details")
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div id="tab3" class="tab-pane fade">
				<div class="row">
					<div class="panel">
						<div class="panel-body" style="margin-top: 20px;">
							@include("admin.bookorders._report_shipping")
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
