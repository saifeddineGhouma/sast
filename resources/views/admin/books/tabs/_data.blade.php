<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-2 control-label">Price</label>
			<div class="col-md-10">
				<input  type="text"  name="price" class="form-control touchspin_1" value="{{$book->price or 0}}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Indicative Price</label>
			<div class="col-md-10">
				<input  type="text"  name="indicative_price" class="form-control touchspin_1" value="{{$book->indicative_price or 0}}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Promo Points</label>
			<div class="col-md-10">
				<input type="text" name="promo_points" class="form-control touchspin_2" value="{{$book->promo_points or 0}}">
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="col-md-2 control-label">Vat</label>
			<div class="col-md-10">
				<input  type="text"  name="vat" class="form-control touchspin_1" value="{{$book->vat or 0}}">
			</div>
		</div>--}}

		<div class="form-group">
			<label class="col-md-2 control-label">Points</label>
			<div class="col-md-10">
				<input  type="text"  name="points" class="form-control touchspin_2" value="{{$book->points or 0}}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Attach File</label>
			<div class="col-md-10">
				<a href="javascript:void(0)">
					<input type="text" name="pdf_book" value="{{$book->pdf_book}}" class="form-control"
						   onclick="openKCFinderLink($(this))" readonly>
				</a>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Attach Summary</label>
			<div class="col-md-10">
				<a href="javascript:void(0)">
					<input type="text" name="pdf_book_summary" value="{{$book->pdf_book_summary}}" class="form-control"
						   onclick="openKCFinderLink($(this))" readonly>
				</a>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-2 control-label">Buy Link</label>
			<div class="col-md-10">
				<input  type="text"  name="buy_link" class="form-control" value="{{$book->buy_link}}">
			</div>
		</div>

	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="col-md-6">
				<a>
					<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))"
						 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
						<img src="{{asset('uploads/kcfinder/upload/image/'.$book->image)}}" id="image-img">
						<input type="hidden" name="image" id="image" value="{{$book->image}}"/>
					</div>
				</a>
				<a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select Thumbnail</a>
			</div>
		</div>
	</div>
</div>
