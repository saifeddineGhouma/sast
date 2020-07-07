<div class="modal fade" id="modal-2">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">{{trans('home.request_price')}}</h3>
            </div>
            <div class="panel-body">  
            	<form id="requestprice_form" method="post" action="{{url(App('urlLang').'/products/requestprice')}}">
            		{{csrf_field()}}
            		<input type="hidden" name="product_id" id="modal-product_id" value=""/>          	
					<div class="form-group">
						<textarea class="form-control" name="user_notes" placeholder="{{trans('home.your_notes')}}"></textarea>
					</div>
		          	
		          	<div class="buttons-holder">             
		            	<button type="button" data-dismiss="modal" class="btn btn-cool btn-lg cancel-form">{{trans('home.cancel')}}</button>
		                <button class="btn btn-cool btn-lg submit" type="submit" >{{trans('home.send')}}</button>
		            </div>
		        </form>
	        </div>
        </div>
    </div>
</div>