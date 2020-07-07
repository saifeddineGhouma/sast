<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
        	<th>#</th>
            <th>en_name</th>
            <th>ar_name</th>
            <th>country</th>
            <th>actions</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($governments as $u)
    	<?php
    		$ar_name = "";
			$en_name = "";
    	?>
        <tr>
        	<td>{{$u->id}}</td>
        	<td>
        		@if(!empty($u->government_trans("en")))
        		<?php
    				$en_name = $u->government_trans("en")->name;
    			?>
        			{{$en_name}}
        		@endif
        	</td>
        	<td>
        		@if(!empty($u->government_trans("ar")))
        			<?php
        				$ar_name = $u->government_trans("ar")->name;
        			?>
        			{{$ar_name}}
        		@endif
        	</td>
            <td>{{$u->country->country_trans("en")->name}}</td>
            <td>
            	<a>
                    <i class="livicon btnedit" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit government"
                    data-toggle="modal" href="#modal-2" data-id="{{$u->id}}" data-ar_name="{{$ar_name}}" data-en_name="{{$en_name}}"
                    data-country_id="{{$u->country_id}}"></i>
                </a>
                <a data-toggle="modal" class="deletegovernment" elementId="{{$u->id}}">
                    <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete government"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>