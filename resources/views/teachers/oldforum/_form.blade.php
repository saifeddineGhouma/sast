  <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('teachers/forum/create/');
		$btn=trans('admin.add');
	}else {
		$url = url('teachers/forum/edit/'.$courseQuestion->id);
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
 			    
	<form action="{{$url}}" method="post" id="forum-form" class="form-horizontal form-row-seperated">
	
		{!!csrf_field()!!}
		<input type="hidden" name="methodForm" value="{{$method}}"/>
		<input type="hidden" id="id" value="{{($method=='edit')?$courseQuestion->id:0}}"/>

		<div class="form-group">
			<label class="control-label col-md-2">Client</label>
			<div class="col-md-10">
				<input  type="text" value="{{$method=='edit'&&!empty($courseQuestion->user)?$courseQuestion->user->username:''}}" class="form-control" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2">Course</label>
			<div class="col-md-10">
				<input  type="text" value="{{$method=='edit'?$courseQuestion->course->course_trans('ar')->name:''}}" class="form-control" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">discussion</label>
			<div class="col-md-10">
				<textarea cols="60"  name="discussion" class="form-control">{{$courseQuestion->discussion}} </textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Status</label>
			<div class="col-sm-10">
				<select name="active" class="form-control">
					<option value="1" {{ $courseQuestion->active?'selected':null }}>Active</option>
					<option value="0" {{ !$courseQuestion->active?'selected':null }}>Not Active</option>
				</select>
			</div>
		</div>

		<h3 class="form-section">Replies</h3>
		<div class="table-responsive">
			<table id="studies" class="table table-striped table-bordered table-hover">
				<thead>
				<tr>
					<td>username</td>
					<td>reply</td>
					<td>status</td>
					<td></td>
				</tr>
				</thead>
				<tbody>
				@foreach($courseQuestion->replies as $reply)
					<tr id="reply-row{{$reply->id}}" data-id="{{$reply->id}}">
						<td>
							@if(!empty($reply->user))
								{{ $reply->user->username }}
							@else
								admin
							@endif
						</td>
						<td>
							<textarea cols="60"  name="reply_discussion_{{$reply->id}}" class="form-control">{{$reply->discussion}} </textarea>
						</td>
						<td>
							<input type="checkbox" name="reply_active_{{$reply->id}}" {{ $reply->active?"checked":null }}>
						</td>
						<td class="text-left"><button type="button" onclick="$('#reply-row{{$reply->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
					</tr>
				@endforeach
				</tbody>
				<tfoot>
				<tr>
					<td colspan="3"></td>
					<td class="text-left"><button type="button" onclick="addReply();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Offer"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				</tfoot>
			</table>
		</div>

		<div class="form-actions" >
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="Saving..." >
						<i class="fa fa-check"></i> {{$btn}}</button>
					<button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/teachers/forum')}}'"><i class="fa fa-reply"></i> الغاء</button>
				</div>
			</div>
		</div>

	</form>
</div>

