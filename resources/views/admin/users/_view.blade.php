<input type="hidden" value="{{$user->id}}" id="user_id"/>
<ul class="nav  nav-tabs ">
    <li class="active">
        <a href="#tab1" data-toggle="tab">
           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
        User Profile</a>
    </li>
    <li>
        <a href="#tab2" data-toggle="tab">
     <i class="livicon" data-name="gift" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
       Addresses</a>
    </li>
    <li>
        <a href="#tab3" data-toggle="tab" >
     <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
       Change Password</a>
    </li>

	<a href="{{url('admin/users/edit/'.$user->id)}}" style="float:right;">edit user</a>
</ul>
<div  class="tab-content mar-top">
    <div id="tab1" class="tab-pane fade active in">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           
                            User Profile
                        </h3>

                    </div>
                    @include("admin.students.tabs._user_details")
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" class="tab-pane fade">
        <div class="row">
            <div class="col-md-12 pd-top">
            	
	                <table class="table table-striped table-bordered">
					   
                        <tr>
                            <td>address</td>
                            <td>
                                <a href="#" data-pk="{{$user->id}}" data-name="address" class="editable" data-title="Edit Address">{{$user->address}}</a>
                            </td>

                        </tr>
                        <tr>
                            <td>date of birth</td>
                            <td>
                            	{{$user->date_of_birth}}
                            </td>

                        </tr>
					</table>
				
            </div>
        </div>
    </div>
    <div id="tab3" class="tab-pane fade">
        <div class="row">
            <div class="col-md-12 pd-top">
                <form id="changepassword-form" action="{{url('admin/users/changepassword')}}" method="post" class="form-horizontal">
                	{{csrf_field()}}
                	<input type="hidden" name="user_id" value="{{$user->id}}"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label for="inputpassword" class="col-md-3 control-label">
                                Password
                                <span class='require'>*</span>
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                    </span>
                                    <input type="password" name="password" id="inputpassword" placeholder="Password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputnumber" class="col-md-3 control-label">
                                Confirm Password
                                <span class='require'>*</span>
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                    </span>
                                    <input type="password" name="confirm_password"  id="inputnumber" placeholder="Password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            &nbsp;
                            <button type="button" class="btn btn-danger" onclick="js:window.location='{{url('/admin/users')}}'">Cancel</button>
                            &nbsp;
                            <input type="reset" class="btn btn-default hidden-xs" value="Reset"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>