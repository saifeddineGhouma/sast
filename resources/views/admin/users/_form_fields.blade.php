<h3 class="form-section">personal info</h3>
  <div class="row">
  	 <div class="col-md-6">
  		 <div class="form-group">
	          <label class="control-label col-md-3">full name ar<span style="color:red;">*</span></label>
	          <div class="col-md-9">
	          	<input  type="text" value="{{$method=='edit'?$user->full_name_ar:''}}" required name="full_name_ar" class="form-control required">
	          </div>
	      </div>
  	</div> 
  	<div class="col-md-6">
  		 <div class="form-group">
	          <label class="control-label col-md-3">full name en<span style="color:red;">*</span></label>
	          <div class="col-md-9">
	          	<input  type="text" value="{{$method=='edit'?$user->full_name_en:''}}" required name="full_name_en" class="form-control required">
	          </div>
	      </div>
  	</div>
    <div class="col-md-6">
      <div class="form-group">
            <label class="control-label col-md-3">E-mail<span style="color:red;">*</span></label>
            <div class="col-md-9">
                <input type="text" class="form-control required" required name="email" value="{{($method=='edit')?$user->email:null}}" id="email">
            </div>
      </div>
    </div>
  </div>
   <div class="row">

    <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-md-3">nationality<span style="color:red;">*</span></label>
            <div class="col-md-9">
              <select type="text" name="nationality" required class="form-control">
                <option value="">choose...</option>
                @foreach($countries as $country)
                  <option value="{{$country->country_trans('en')->name}}" {{($method=="edit" && $user->nationality == $country->country_trans("en")->name)?'selected':null}}>
                    {{$country->country_trans("en")->name}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

    <div class="col-md-6">
     <div class="form-group">
            <label class="control-label col-md-3">Gender<span style="color:red;">*</span></label>
            <div class="col-md-3">
                <div class="radio-list">
                    <label>
                        <input type="radio" name="gender" required value="male"  {{ (isset($user->gender) && $user->gender=="male")?"checked":null}} {{$method=="add"?"checked":null}}/>
                        male  </label>
                    <label>
                        <input type="radio" name="gender" required value="female" {{(isset($user->gender) && $user->gender=="female")?"checked":null}} />
                        female </label>
                </div>
            </div>
        </div>
    </div>
<!--   	<div class="col-md-6">
  		<div class="form-group">
            <label class="control-label col-md-3">phone</label>
            <div class="col-md-9">
                <input type="text" class="form-control required" name="phone" required value="{{($method=='edit')?$user->phone:null}}" id="phone">
            </div>
      </div>
      
  	</div> -->
  </div>
  <div class="row">
 
    <div class="col-md-6">
        <div class="form-group">
                <label class="control-label col-md-3">date of birth<span style="color:red;">*</span></label>
                <div class="col-md-9">
                    <?php
                    $day=0;
                    $month1=0;
                    $year=0;
                    if($method=='edit' && $user->date_of_birth){
                        $day = intval(date("d",strtotime($user->date_of_birth)));
                        $month1 = intval(date("m",strtotime($user->date_of_birth)));
                        $year = intval(date("Y",strtotime($user->date_of_birth)));
                    }

                    ?>

                    <select name="days" class="form-control" required placeholder="{{trans('student.days')}}" style="display: inline-block!important;width: 20%!important;">
                        <option value="0">day</option>
                        @for($i=1;$i<=31;$i++)
                            <option value="{{$i}}" {{($i==$day)?"selected":null}}>{{$i}}</option>
                        @endfor
                    </select>
                    <select name="months" class="form-control" required style="display: inline-block!important;width: 22%!important;">
                        <option value="0">month</option>
                        @foreach($monthsArr as $key=>$month)
                            <option value="{{$key}}" {{($key==$month1)?"selected":null}}>{{$month}}</option>
                        @endforeach
                    </select>
                    <select name="years"  class="form-control" required style="display: inline-block!important;width: 30%!important;">
                        <option value="0">year</option>
                        @for($i=intval(date("Y"));$i>=1950;$i--)
                            <option value="{{$i}}" {{($i==$year)?"selected":null}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
        </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
            <label class="control-label col-md-3">mobile<span style="color:red;">*</span></label>
            <div class="col-md-9">
              <input  type="text" value="{{$method=='edit'?$user->mobile:''}}" required maxlength="16" id="mobile" name="mobile_full" class="form-control">
            </div>
        </div>
    </div>

  </div>


    <div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">clothing size<span style="color:red;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" name="clothing_size" required>
                    <option value="S" {{$method=='edit'&&$user->clothing_size=="S"?"selected":null }}>S</option>
                    <option value="M" {{$method=='edit'&&$user->clothing_size=="M"?"selected":null }}>M</option>
                    <option value="L" {{$method=='edit'&&$user->clothing_size=="L"?"selected":null }}>L</option>
                    <option value="XL" {{$method=='edit'&&$user->clothing_size=="XL"?"selected":null }}>XL</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
            <label class="control-label col-md-3">address<span style="color:red;">*</span></label>
            <div class="col-md-9">
                <input type="text" class="form-control" required name="address" value="{{($method=='edit')?$user->address:null}}">
            </div>
        </div>
    </div>
        <!-- <div>
        </div>v class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-3">government</label>
                <div class="col-md-9">
                    <input type="text" name="government_id" required id="government_id"  value="{{($method=='edit')?$user->government:''}}" class="form-control government_id" />
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">zip code</label>
            <div class="col-md-9">
                <input type="text" class="form-control" required name="zip_code" value="{{($method=='edit')?$user->zip_code:null}}">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">streat</label>
            <div class="col-md-9">
                <input type="text" class="form-control" required name="streat" value="{{($method=='edit')?$user->streat:null}}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">house number</label>
            <div class="col-md-9">
                <input type="text" class="form-control" required name="house_number" value="{{($method=='edit')?$user->house_number:null}}">
            </div>
        </div>
    </div> -->

</div>

  <div class="row">
  	<div class="col-md-6">
  		<div class="form-group">
            <label class="col-md-2 control-label" for="name">image<span style="color:red;">*</span></label>
            <div class="col-md-10">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="image"></span>
                    <a href="javascript:;" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
                <div class="col-md-9">
					<?php if($method=="edit"){?>
						@include('admin.users._images',array('user'=>$user))
					<?php }?>
				</div>
            </div>
        </div>
  	</div>
  	<div class="col-md-6">
      <div class="form-group">
            <label class="col-md-2 control-label" for="name">Passport<span style="color:red;">*</span></label>
            <div class="col-md-10">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail img-file">
                @if($method=="edit")
                    <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->passport)}}" >
                @endif
            </div>

            <div class="fileinput-preview fileinput-exists thumbnail img-max"></div>
            <div>
                    <span class="btn btn-default btn-file">
                        <span class="fileinput-new">Select Passport</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="passport"></span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
        </div>

    	</div>
    </div>
  </div>
</div>



<div class="row">
    @if(!(isset($page) && $page=="front"))
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-6">active</label>
                <div class="col-md-6">
                    <input type="checkbox" name="active" class="make-switch" {{$method=="add"?"checked":null}} {{ (isset($user->active) && $user->active)?'checked':'' }} data-on-text="Yes" data-off-text="No">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-6">email verified</label>
                <div class="col-md-6">
                    <input type="checkbox" name="email_verified" class="make-switch" {{$method=="add"?"checked":null}} {{ (isset($user->email_verified) && $user->email_verified)?'checked':'' }} data-on-text="Yes" data-off-text="No">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-6">mobile verified</label>
                <div class="col-md-6">
                    <input type="checkbox" name="mobile_verified" class="make-switch" {{$method=="add"?"checked":null}} {{ (isset($user->mobile_verified) && $user->mobile_verified)?'checked':'' }} data-on-text="Yes" data-off-text="No">
                </div>
            </div>
        </div>
    @endif
</div>
  
  
  <h3 class="form-section">user info</h3>
  <div class="form-group">
      <label class="control-label col-md-3">{{trans('home.username')}} <span style="color:red;">*</span></label>
      <div class="col-md-9">
      	<input  type="text" required value="{{$method=='edit'?$user->username:''}}" id="username" name="username" class="form-control required"> 	
      </div>
  </div>
 
  <div class="form-group " >
  	<div class="col-md-4 col-md-offset-3">
  		<input type="checkbox"  id="checkPassword" name="checkPassword" >change password
  	</div>
  </div>
  <div id="passwordDiv" class="display-none">
  	<div class="form-group">
        <label class="control-label col-md-3">{{trans('home.password')}}  </label>
        <div class="col-md-4">
            <input type="password" required id="password" placeholder="{{trans('home.password')}}"  name="password" class="form-control"/>
        </div>
    </div>
   
    <div class="form-group">
        <label class="control-label col-md-3">{{trans('home.confirm_password')}}</label>
        <div class="col-md-4">
            <input type="password" required id="confirm_password" placeholder="{{trans('home.confirm_password')}}" name="confirm_password" class="form-control"/>
        </div>            
    </div>
  </div>