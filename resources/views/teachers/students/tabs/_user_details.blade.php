<div class="panel-body">
    <div class="col-md-4">
    	<div id="imageDiv">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail img-file">
                    <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->image)}}" alt="{{$user->username}}"></div>
                <div class="fileinput-preview fileinput-exists thumbnail img-max"></div>
                
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
                            {{$user->username}}
                        </td>

                    </tr>
                    <tr>
                        <td>Full Name Ar</td>
                        <td>
                           {{$user->full_name_ar}}
                        </td>

                    </tr>
                    <tr>
                        <td>Full Name En</td>
                        <td>
                           {{$user->full_name_en}}
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
                           {{$user->email}}
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