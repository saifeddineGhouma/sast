<div class="container">

    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.full_name')}} <span>*</span></label>
                <input type="text" class="form-control" name="full_name_en" value="{{ $user->full_name_en }}"  >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.email')}} <span>*</span></label>
                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
            </div>
        </div>
    </div>



    @php $pull = session()->get('locale') === "ar" ? "pull-right" : "pull-left" @endphp

    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label ">{{trans('home.username')}}</label>
                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-3 {{ $pull}} ">{{trans('navbar.sexe')}}   <span>*</span></label>
                <div class="col-md-9">
                    <div class="radio-list">
                        <label>
                            <input type="radio" name="gender" required value="male" {{ (isset($user->gender) && $user->gender=="male")?"checked":null}}  />
                            {{trans('home.man')}}   </label>
                        <label>
                            <input type="radio" name="gender" required value="female" {{ (isset($user->gender) && $user->gender=="female")?"checked":null}} />
                            {{trans('home.woman')}} </label>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.date_birth')}}  <span>*</span></label>
                <input class="form-control date-picker" name="date_of_birth" placeholder="yyyy-m-d" value="{{ $user->date_of_birth }}" type="text"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.country_info')}} <span>*</span></label>
                <select class="form-control country_id" name="country_id">
                    <option value=""></option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}" {{ $user->nationality==$country->country_trans("en")->name?"selected":null }} >
                            {{$country->country_trans(Session()->get('locale'))->name or $country->country_trans("en")->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>




 



    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.adress_info')}}  <span>*</span></label>
                <input type="text" class="form-control" name="address" value="{{ $user->address }}" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"> {{trans('home.num_tel')}}<span>*</span></label>
                <input type="text" class="form-control"  dir="ltr" name="mobile" id="mobile"  value="{{ $user->mobile }}" style="direction: ltr !important;text-align: right;">
            </div>
        </div>
    </div>







    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">{{trans('home.photo_personnel')}}  </label>
                <input type="file" class="form-control" name="image">
                <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->image)}}" alt="" width="100px;"/>
                <span class="help-inline maxflsize">{{trans('home.max_size')}} </span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                {{-- <label class="form-label">{{trans('home.copy_passport_identity')}}   </label>
                <input type="file" class="form-control" name="passport" {{ $user->passport ? '' : 'required' }}>
                <img src="{{asset('uploads/kcfinder/upload/image/users/'.$user->passport)}}" alt="" width="100px;"/>
                <span class="help-inline maxflsize">{{trans('home.max_size')}} </span> --}}
            </div>
        </div>
    </div>

</div>



