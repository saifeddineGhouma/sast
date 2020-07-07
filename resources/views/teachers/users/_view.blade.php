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
                    @include("teachers.students.tabs._user_details")
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
                                {{$user->address}}
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
</div>