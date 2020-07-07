
<div class="table-responsive">
	<table id="socials" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-left">name</td>
          <td>font</td>
          <td class="text-right">link</td>
          <td></td>
        </tr>
      </thead>
      <tbody>  
      @if($method=="edit")	                               
	      @foreach($teacher->socials as $social)                                         
		       <tr id="link-row{{$social->id}}" data-id="{{$social->id}}">
		          <td class="text-left">
		          	<a href="javascript:void(0)">
		          		<input type="text" name="social_name_{{$social->id}}" value="{{$social->name}}" class="form-control">
		          	</a>
		          </td>
		          <td>
		          	<select class="form-control" name="social_font_{{$social->id}}">
		          		@foreach($socialArray as $key=>$value)
		          			<option value="{{$key}}" {{($key==$social->font)?"selected":null}}>{{$value}}</option>
		          		@endforeach
		          	</select>		          	
		          </td>
		          <td class="text-right">
		          	<input type="text" name="social_link_{{$social->id}}" value="{{$social->link}}" class="form-control">
		          </td>
		          <td class="text-left"><button type="button" onclick="$('#link-row{{$social->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
		        </tr>                                 
	      @endforeach
	  @endif                                          
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td class="text-left"><button type="button" onclick="addSocial();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Social"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
      </tfoot>
    </table>
</div>

