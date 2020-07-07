<a href="{{url('admin/users/edit/'.$user->id)}}"  style="float:right">edit user</a>
<div class="panel-body">
    <div class="col-md-4">
    	<div id="imageDiv">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail img-file">
                    <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->image)}}" alt="{{$user->username}}"></div>
                <div class="fileinput-preview fileinput-exists thumbnail img-max"></div>
                <div>
                    <span class="btn btn-default btn-file">
                        <span class="fileinput-new">Select image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="image"></span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="users">

                    <tr>
                        <td>User Name</td>
                        <td>
                            <a href="#" data-pk="{{$user->id}}" data-name="username" class="editable" data-title="Edit User Name">{{$user->username}}</a>
                        </td>

                    </tr>
              <!--       <tr>
                        <td>Full Name Ar</td>
                        <td>
                            <a href="#" data-pk="{{$user->id}}" data-name="full_name_ar" class="editable" data-title="Edit Full Name Ar">{{$user->full_name_ar}}</a>
                        </td>

                    </tr> -->
                    <tr>
                        <td>Full Name En</td>
                        <td>
                            <a href="#" data-pk="{{$user->id}}" data-name="full_name_en" class="editable" data-title="Edit Full Name En">{{$user->full_name_en}}</a>
                        </td>

                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>
                            {{$user->mobile}}
                        </td>

                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>
                            <a href="#" data-pk="{{$user->id}}" data-name="email" class="editable" data-title="Edit E-mail">{{$user->email}}</a>
                        </td>
                    </tr> 
                    <tr>
                        <td>nationality</td>
                        <td>
                        	{{$user->nationality}}
                        </td>
                    </tr>                                      
                    <tr>
                        <td>Created At</td>
                        <td>
                            {{date("Y-m-d",strtotime($user->created_at))}}
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>
</div>