<!-- BEGIN FORM-->
<?php
	$url="";
	
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/invoice/create');
		}else {
			$button = "<i class='fa fa-pencil'></i> edit";
			$url = url('admin/invoice/edit/'.$factures->id); 
			
		}
	?>

<form method="POST" id="" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped">
    <div class="form-body">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $factures->id:'0'}}">
		
        {{csrf_field()}}
		
		<div class="form-group">
    		<label class="col-md-3 control-label">Client <span style="color:red;">*</span></label>
    		<div class="col-md-6">
    			<input type="text" name="client" required value="{{$method=='edit'?$factures->client:''}}" class="form-control">
    		</div>
    	</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">Company name </label>
			<div class="col-md-6">	
		       <input  type="text"  name="company" class="form-control" value="{{($method=='edit')?$factures->company:''}}">
		    </div>
		</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">Address <span style="color:red;">*</span></label>
			<div class="col-md-6">	
		       <input  type="text"  name="address" class="form-control" value="{{($method=='edit')?$factures->address:''}}">
		    </div>
		</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">E-mail <span style="color:red;">*</span></label>
			<div class="col-md-6">	
		       <input  type="text"  name="email" class="form-control" value="{{($method=='edit')?$factures->email:''}}">
		    </div>
		</div>  
		<div class="form-group">
		    <label class="col-md-3 control-label">Phone <span style="color:red;">*</span></label>
			<div class="col-md-6">	
		       <input  type="text"  name="phone" class="form-control" value="{{($method=='edit')?$factures->tel:''}}">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-3 control-label">Company invoice <span style="color:red;">*</span></label>
			<div class="col-md-6">	
		       <select name="company_invoice" class="form-control">
					@if(($method=='edit'))
						@if(($factures->company_invoice=='1'))
							<option value="1" selected>SAST (25%)</option>
							<option value="2">GCSS (19%)</option>
						@else
							<option value="1">SAST (25%)</option>
							<option value="2" selected>GCSS (19%)</option>
						@endif
					@else
						<option value="1">SAST (25%)</option>
						<option value="2">GCSS (19%)</option>
					@endif
			   </select>
		    </div>
		</div>  
		<div class="form-group">
		    <label class="col-md-3 control-label">Discount <span style="color:red;">*</span></label>
			<div class="col-md-6">	
		       <input  type="text"  name="discount" class="form-control" value="{{($method=='edit')?$factures->discount:''}}">
		    </div>
		</div> 
		<div class="table-responsive">
			<table id="variations_facture" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<td>Quantity</td>
						<td>Description</td>
						<td>Unit price</td>
						<td>Amount</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@if(isset($facturesdetails))
						@if($facturesdetails->count()>0)
							@foreach($facturesdetails as $facturesdetailss)
								<tr id="variation_facture-row{{$facturesdetailss->id}}" data-id="{{$facturesdetailss->id}}">
									<td>
										<input type="text" name="qte_{{$facturesdetailss->id}}" id="qte{{$facturesdetailss->id}}" onchange="montant({{$facturesdetailss->id}})" class="form-control touchspin_2" value="{{$facturesdetailss->quantite}}" />
									</td>
									<td>
										<input type="text" name="desc_{{$facturesdetailss->id}}" class="form-control" value="{{$facturesdetailss->description}}" />
									</td>
									<td>
										<input type="text" name="price_{{$facturesdetailss->id}}" id="price{{$facturesdetailss->id}}" onchange="montant({{$facturesdetailss->id}})" class="form-control touchspin_1" value="{{$facturesdetailss->unite}}" />
									</td>
									<td>
										<div id="montant{{$facturesdetailss->id}}">
											$<?php echo $facturesdetailss->quantite*$facturesdetailss->unite; ?>
										</div>
									</td>
									<td>
										<button type="button" onclick="$('#variation_facture-row{{$facturesdetailss->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
									</td>
								</tr>
							@endforeach
						@endif
					@endif
				</tbody>
				<tfoot>
				<tr>
					<td colspan="4"></td>
					<td class="text-left"><button type="button" onclick="addVariation('facture');" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				</tfoot>
			</table>
		</div>

        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/invoice')}}'"><i class="fa fa-reply"></i>Cancel</button>
            </div>
        </div>
    </div>

</form>

