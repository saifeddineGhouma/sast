<div class="table-responsive">
	<table id="discounts" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td>number of students</td>
          <td>discount</td>
          <td>type</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
	      @foreach($course->courseDiscounts as $courseDiscount)
		       <tr id="discount-row{{$courseDiscount->id}}" data-id="{{$courseDiscount->id}}">
				   <td class="text-left">
					   <input  type="text"  name="discount_num_students_{{$courseDiscount->id}}" class="form-control touchspin_4" value="{{$courseDiscount->num_students or 0}}">
				   </td>
		          <td>
					  <div class="percentage">
						  <input type="text" name="discount_discount_{{$courseDiscount->id}}" class="form-control touchspin_5" value="{{$courseDiscount->discount}}">
					  </div>
		          </td>
                   <td>
                       <label>
                           <input type="checkbox" name="discount_type_{{$courseDiscount->id}}[0]" value="online" {{ in_array("online", explode(",", $courseDiscount->type))  ? " checked" : "" }}/>
                           online
                       </label>
                       <label>
                           <input type="checkbox" name="discount_type_{{$courseDiscount->id}}[1]" value="presence" {{ in_array("presence", explode(",", $courseDiscount->type))  ? " checked" : "" }}/>
                           presence
                       </label>
                   </td>
		          <td class="text-left"><button type="button" onclick="$('#discount-row{{$courseDiscount->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
		        </tr>                                 
	      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Offer"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
      </tfoot>
    </table>
</div>
