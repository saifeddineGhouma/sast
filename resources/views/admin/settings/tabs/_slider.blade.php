<div class="table-responsive" id="sliderimages">
	<ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab_3" data-toggle="tab" aria-expanded="true"> 
              <img src="{{asset('assets/admin/img/flags/gb.png')}}">
                English 
            </a>
        </li>
       <li>
           <a href="#tab_4" data-toggle="tab" aria-expanded="true"> 
            	<img src="{{asset('assets/admin/img/flags/kw.png')}}">
            	 Arabic
            </a>
       </li>
   </ul>
   <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_3">
        	<table id="images-en" class="table table-striped table-bordered table-hover">
		      <thead>
		        <tr>
		          <td class="text-left">Additional Images</td>
		          <td>title</td>
		          <td>description</td>
		          <td>link</td>
		          <td class="text-right">Sort Order</td>
		          <td class="text-right">Active</td>
		          <td></td>
		        </tr>
		      </thead>
		      <tbody>  
		      @if($method=="edit")	                               
			      @foreach($setting->sliderimages()->where("lang","en")->get() as $image)                                         
				       <tr id="image-row_en{{$image->id}}" data-id="{{$image->id}}">
				          <td class="text-left">
				          	<a href="javascript:void(0)" id="thumb-image{{$image->id}}" data-toggle="image" class="img-thumbnail">
				          		<div class="fileinput-new thumbnail" onclick="openKCFinder($('#sliderimage{{$image->id}}'),$('#sliderimage_image_{{$image->id}}'))" data-trigger="fileinput" style="width: 100px; height: 100px;margin-bottom: 0px;">
				          			<img src="{{asset('uploads/kcfinder/upload/image/'.$image->image)}}" id="sliderimage{{$image->id}}">
				          		</div>
				          	</a>
				          	<input type="hidden" name="sliderimage_image_{{$image->id}}" value="{{$image->image}}" id="sliderimage_image_{{$image->id}}">
				          </td>
				          <td>
				          	<input type="text" name="sliderimage_title_{{$image->id}}" value="{{$image->title}}" placeholder="Title" class="form-control">
				          </td>
				          <td>
				          	<textarea name="sliderimage_description_{{$image->id}}" cols="60" placeholder="Description" class="form-control">{{$image->description}}</textarea>
				          </td>
				          <td>
				          	<input type="text" name="sliderimage_link_{{$image->id}}" value="{{$image->link}}" placeholder="Link" class="form-control">
				          </td>
				          <td class="text-right">
				          	<input type="text" name="sliderimage_sortorder_{{$image->id}}" value="{{$image->sort_order}}" placeholder="Sort Order" class="form-control">
				          </td>
				          <td class="text-right">
				          	<input type="checkbox" name="sliderimage_active_{{$image->id}}" {{$image->active?"checked":null}} placeholder="Active" >
				          </td>
				          <td class="text-left"><button type="button" onclick="$('#image-row_en{{$image->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
				        </tr>                                 
			      @endforeach
			  @endif                                          
		      </tbody>
		      <tfoot>
		        <tr>
		          <td colspan="6"></td>
		          <td class="text-left"><button type="button" onclick="addImage('en');" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
		        </tr>
		      </tfoot>
		    </table>
        </div>
        
        <div class="tab-pane fade" id="tab_4">
        	<table id="images-ar" class="table table-striped table-bordered table-hover">
		      <thead>
		        <tr>
		          <td class="text-left">Additional Images</td>
		          <td>title</td>
		          <td>description</td>
		          <td>link</td>
		          <td class="text-right">Sort Order</td>
		          <td class="text-right">Active</td>
		          <td></td>
		        </tr>
		      </thead>
		      <tbody>  
		      @if($method=="edit")	                               
			      @foreach($setting->sliderimages()->where("lang","ar")->get() as $image)                                         
				       <tr id="image-row_ar{{$image->id}}" data-id="{{$image->id}}">
				          <td class="text-left">
				          	<a href="javascript:void(0)" id="thumb-image{{$image->id}}" data-toggle="image" class="img-thumbnail">
				          		<div class="fileinput-new thumbnail" onclick="openKCFinder($('#sliderimage{{$image->id}}'),$('#sliderimage_image_{{$image->id}}'))" data-trigger="fileinput" style="width: 100px; height: 100px;margin-bottom: 0px;">
				          			<img src="{{asset('uploads/kcfinder/upload/image/'.$image->image)}}" id="sliderimage{{$image->id}}">
				          		</div>
				          	</a>
				          	<input type="hidden" name="sliderimage_image_{{$image->id}}" value="{{$image->image}}" id="sliderimage_image_{{$image->id}}">
				          </td>
				          <td>
				          	<input type="text" name="sliderimage_title_{{$image->id}}" value="{{$image->title}}" placeholder="Title" class="form-control">
				          </td>
				          <td>
				          	<textarea name="sliderimage_description_{{$image->id}}" cols="60" placeholder="Description" class="form-control">{{$image->description}}</textarea>
				          </td>
				          <td>
				          	<input type="text" name="sliderimage_link_{{$image->id}}" value="{{$image->link}}" placeholder="Link" class="form-control">
				          </td>
				          <td class="text-right">
				          	<input type="text" name="sliderimage_sortorder_{{$image->id}}" value="{{$image->sort_order}}" placeholder="Sort Order" class="form-control">
				          </td>
				          <td class="text-right">
				          	<input type="checkbox" name="sliderimage_active_{{$image->id}}" {{$image->active?"checked":null}} placeholder="Active" >
				          </td>
				          <td class="text-left"><button type="button" onclick="$('#image-row_ar{{$image->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
				        </tr>                                 
			      @endforeach
			  @endif                                          
		      </tbody>
		      <tfoot>
		        <tr>
		          <td colspan="6"></td>
		          <td class="text-left"><button type="button" onclick="addImage('ar');" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
		        </tr>
		      </tfoot>
		    </table>
        </div>
   </div>
</div>