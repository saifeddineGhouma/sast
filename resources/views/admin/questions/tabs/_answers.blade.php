<div class="table-responsive">
	<table id="answers" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td>name ar</td>
          <td>name en</td>
          <td>correct</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
	      @foreach($question->answers as $answer)
		       <tr id="answer-row{{$answer->id}}" data-id="{{$answer->id}}">
				   <td>
					   <input  type="text"  name="answer_name_ar_{{$answer->id}}" class="form-control" value="{{$answer->name_ar}}">
				   </td>
                   <td>
                       <input  type="text"  name="answer_name_en_{{$answer->id}}" class="form-control" value="{{$answer->name_en}}">
                   </td>
		          <td>
                      <input type="checkbox" name="answer_is_correct_{{$answer->id}}" class="form-control" {{ $answer->is_correct?"checked":null }}>
		          </td>
		          <td class="text-left"><button type="button" onclick="$('#answer-row{{$answer->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
		        </tr>                                 
	      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td class="text-left"><button type="button" onclick="addAnswer();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Answer"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
      </tfoot>
    </table>
</div>
