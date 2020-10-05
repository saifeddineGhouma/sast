<div class="table-responsive">
	<table id="studies" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td>name ar </td>
          <td>name en</td>
          <td>Lang</td>
          <td>type</td>
			<td colspan="2">url</td>
			
          <td></td>
        </tr>
      </thead>
      <tbody>
	  	@foreach($course->studies as $courseStudy)
		       <tr id="study-row{{$courseStudy->id}}" data-id="{{$courseStudy->id}}">
		          <td>
					   <input type="text" class="form-control" name="study_name_ar_{{$courseStudy->id}}" value="{{$courseStudy->name_ar}}">
					  <input  type="text"  name="study_duration_{{$courseStudy->id}}" class="form-control touchspin_6" value="{{$courseStudy->duration or 0}}">
				  </td>
				  <td>
					   <input type="text" class="form-control" name="study_name_en_{{$courseStudy->id}}" value="{{$courseStudy->name_en}}">
				  </td>
				  <td>
				  	<select class="form-control"name="study_lang_{{$courseStudy->id}}">
				  		<option>لغات الدراسة</option>
				  		<option value="Ar" {{ $courseStudy->lang == 'Ar' ? 'selected' : '' }}>عربية</option>
				  		<option value="Fr" {{ $courseStudy->lang == 'Fr' ? 'selected' : '' }}>فرنسية</option>
				  	</select>
				  	

				  </td>
				  <td>
					   <div class="radio-list">
						   <label>
							   <input type="radio" name="study_type_{{$courseStudy->id}}" class="study_choise"  value="pdf" {{$courseStudy->type == "pdf"?"checked":null}}/>
							   pdf  </label>
						   <label>
							   <input type="radio" name="study_type_{{$courseStudy->id}}" class="study_choise"  value="video" {{$courseStudy->type == "video"?"checked":null}}/>
							   video </label>
						   <label>
							   <input type="radio" name="study_type_{{$courseStudy->id}}" class="study_choise"  value="html" {{$courseStudy->type == "html"?"checked":null}}/>
							   html </label>
					   </div>
					  <label>
					  	<input type="checkbox" name="study_only_registered_{{$courseStudy->id}}" {{ $courseStudy->only_registered?"checked":null }} />
						  only registered
					  </label>
				  </td>
		          <td colspan="2">
					  <div class="pdf">
						  <input type="text" class="form-control" id="study_url_{{$courseStudy->id}}" name="study_pdf_{{$courseStudy->id}}" value="{{$courseStudy->url}}">
						  <a onclick="openKCFinderLink($('#study_url_{{$courseStudy->id}}'))">browse server</a>
					  </div>
					  <div class="video" style="display: none;">
						  <input type="text" class="form-control" id="video_url_{{$courseStudy->id}}" name="study_url_{{$courseStudy->id}}" value="{{$courseStudy->url}}">
						  <a onclick="openKCFinderLink($('#video_url_{{$courseStudy->id}}'))">browse server</a>
					  </div>
					  <div class="content_html" style="display: none;">
							<textarea cols="60" id="study_content_{{$courseStudy->id}}" name="study_content_{{$courseStudy->id}}" class="form-control ckeditor">{{$courseStudy->content}} </textarea>
					  </div>
		          </td>
		          <td>Test</td>
		          {{-- <td>
					  <input  type="text"  name="study_duration_{{$courseStudy->id}}" class="form-control touchspin_6" value="{{$courseStudy->duration or 0}}">
		          </td>--}}
		          <td class="text-left"><button type="button" onclick="$('#study-row{{$courseStudy->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
		        </tr>                                 
	      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5"></td>
          <td class="text-left"><button type="button" onclick="addStudy();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Offer"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
      </tfoot>
    </table>
</div>
