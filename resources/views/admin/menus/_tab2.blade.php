<div class="note note-success">
	<p>
		Your theme supports 
			5 menu. 
		Select which menu appears in each location.
	</p>
</div>
<div id="tab2">
	<table  id="tableTab2" class="table" style="width: 50%;">
		<thead>
			<tr>
				<th>
					Theme Location
				</th>
				<th>
					Assigned Menu
				</th>
			</tr>
		</thead>
		<tbody>
		 
		 @foreach($menuposes as $u)
		<tr >
			<td>
				 {{ $u->name}}
			</td>
			<td>				
				 <select class="bs-select form-control1 input-medium" positionId="{{$u->id}}" data-style="btn-primary">
					
					<?php $menus = App\Menu::get();?>
					<option value="0">-- choose menu --</option>
					@foreach($menus as $menu)
							<option value="{{$menu->id}}" {{($u->menus_menupos()->where("menu_id",$menu->id)->count()>0)?"selected":null}}>{{$menu->name}}</option>
					@endforeach	
				</select>
			</td>
		</tr>
		@endforeach
	
		</tbody>
	</table>
	<button id="savePos" type="button" data-loading-text="saving..." class="btn green demo-loading-btn"><i class="fa fa-save"></i> Save</button>
</div>