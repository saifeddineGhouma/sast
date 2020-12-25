<div class="container">


<div class="row userlogedin">
    <div class="col-md-6">
            <div class="form-group">
                <label class="form-label ">{{trans('home.username')}}<span>*</span></label>
                <input type="text" class="form-control" value=""  name="username">
            </div>
        </div>
       
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.email')}} <span>*</span></label>
                <input type="text" class="form-control" name="email" value="" required>
            </div>
        </div>
         <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.password')}} <span>*</span></label>
                <input type="password" class="form-control" name="password" value=""  required>
            </div>
        </div>
         <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.confirm_pwd')}} <span>*</span></label>
                <input type="password" class="form-control" name="confirm_password" value=""  required>
            </div>
        </div>
          
    </div>

    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.full_name')}} <span>*</span></label>
                <input type="text" class="form-control" name="full_name_en" value=""  required>
            </div>
        </div>
        
    </div>



    @php $pull = session()->get('locale') === "ar" ? "pull-right" : "pull-left" @endphp

    <div class="row userlogedin">
        
       
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-3 {{ $pull}} ">{{trans('navbar.sexe')}}   <span>*</span></label>
                <div class="col-md-9">
                    <div class="radio-list">
                        <label>
                            <input type="radio" name="gender" required value="male" />
                            {{trans('home.man')}}   </label>
                        <label>
                            <input type="radio" name="gender" required value="female" />
                            {{trans('home.woman')}} </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row userlogedin">
              
            
            <div class="col-md-6" >
            <div class="form-group">
                <label class="form-label">{{trans('home.date_birth')}}  <span></span></label>
                <input class="form-control date-picker" name="date_of_birth" placeholder="yyyy-m-d" value="" type="text"/>
            </div>
        </div>
           
     
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">{{trans('home.country_info')}} <span>*</span></label>
                <select class="form-control country_id" name="country_id">
                    <option value=""></option>
                    @if(isset($countries))
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->country_trans(Session()->get('locale'))->name or $country->country_trans("en")->name}} 
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>




    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.adress_info')}}  <span>*</span></label>
                <input type="text" class="form-control" name="address" value="" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"> {{trans('home.num_tel')}}<span>*</span></label>
                <input type="text" class="form-control"  dir="ltr" name="mobile" id="mobile"  value="" style="direction: ltr !important;text-align: right;">
            </div>
        </div>

      

    </div>
    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.photo_personnel')}}  </label>
                <input type="file" class="form-control" name="image">
                @if(isset($user))
                <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->image)}}" alt="" width="100px;"/>

                @endif
                <span class="help-inline maxflsize">{{trans('home.max_size')}} </span>
            </div>
        </div>



       
    </div>

</div>

