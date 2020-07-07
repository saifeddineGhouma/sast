<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
        	<th>#</th>
            <th>name</th>
            <th>email</th>
            <th>mobile</th>
            <th>status</th>
            <th>actions</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($agents as $u)
        <tr>
        	<td>{{$u->id}}</td>
        	<td>
        		{{ $u->name }}
        	</td>
        	<td>
                {{ $u->email }}
        	</td>
            <td>{{ $u->mobile }}</td>
            <td>
                {!! $u->getStatus($u->active,$u->id) !!}
            </td>
            <td>
            	<a>
                    <i class="livicon btnedit" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit agent"
                    data-toggle="modal" href="#modal-2" data-id="{{$u->id}}" data-country_id="{{ $u->country_id }}" data-name="{{$u->name}}" data-email="{{$u->email}}"
                    data-mobile="{{$u->mobile}}" data-address="{{$u->address}}"></i>
                </a>
                <a data-toggle="modal" class="deleteagent" elementId="{{$u->id}}">
                    <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete agent"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>