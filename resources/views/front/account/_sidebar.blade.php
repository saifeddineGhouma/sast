@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
<div class="col-lg-3 text-right  filteration_method">
    @if(!$user->email_verified)
        <div class="alert alert-info" data-alert="" style="text-align: {{$alignText}}" ><ul>
                <li>{{trans('home.you_notverified_email')}} <a href="{{url(App('urlLang').'account/email-verification')}}" style='color: #23a1d1;'>{{trans('home.click_here')}} </a>{{trans('home.to_activate')}}.</li>
            </ul>
        </div>
    @endif
    {{-- @if(!$user->mobile_verified)  
        <div class="alert alert-info" data-alert=""><ul>
                @if($user->mobile!="")
                    <li>{{trans('home.you_notverified_mobile')}} <a href="{{url(App('urlLang').'account/mobile-verification')}}" style='color: #23a1d1;'>{{trans('home.click_here')}}</a>{{trans('home.to_activate')}}.</li>
                @else
                    <li>{{trans('home.you_not_added_mobile')}} <a href="{{url(App('urlLang').'account/info')}}" style='color: #23a1d1;'>{{trans('home.click_here')}}</a>{{trans('home.to_add_mobile')}}</li>
                @endif
            </ul>
        </div>
    @endif
    --}}
    @php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
  
    <div class="m-menu account_content text-right" style="direction:{{ $dir }}" >
        <h5 class="head-side"><i class="fa click fa-bars" title="Click me!"></i> {{trans('home.control_panel')}} </h5>
        <ul style="text-align: {{$alignText}}" >
            <li><a href="{{ url(App('urlLang').'account') }}" class="link-side"><span><i class="fa fa-th-large"></i>{{trans('home.home')}} </span></a></li>
            <li><a href="{{ url(App('urlLang').'account/info') }}" class="link-side"><span><i class="fa fa-pencil"></i> {{trans('home.modifier_coordonne')}}</span></a></li>
            <li><a href="{{ url(App('urlLang').'account/change-password') }}" class="link-side"><span><i class="fa fa-lock"></i> {{trans('home.password')}}</span></a></li>
        </ul>
        <ul style="text-align: {{$alignText}} ">
            <h5 class="head-side">{{trans('home.the_shopping')}} </h5>
            <li><a href="{{ url(App('urlLang').'account/orders') }}" class="link-side"><span><i class="fa fa-credit-card"></i> {{trans('home.mes_demandes')}}</span></a></li>
            <li><a href="{{ url(App('urlLang').'account/points') }}" class="link-side"><span><i class="fa fa-shopping-bag"></i> {{trans('home.mes_points')}}</span></a></li>
            <li><a href="{{ url(App('urlLang').'account/coupons') }}" class="link-side"><span><i class="fa fa-shopping-bag"></i> {{trans('home.my_coupons')}}</span></a></li>
        </ul>
        <ul style="text-align: {{$alignText}}">
            <h5 class="head-side">{{trans('home.certif_book')}}</h5>
            <li><a href="{{ url(App('urlLang').'account/certificates') }}" class="link-side"><span><i class="fa fa-graduation-cap"></i> {{trans('home.certif_compte')}}</span></a></li>
            <li><a href="{{ url(App('urlLang').'account/books') }}" class="link-side"><span><i class="fa fa-file"></i>{{trans('home.books_compte')}} </span></a></li>	
			@if(isset($user->teacher->id))		
				<li>
					<a href="{{ url(App('urlLang').'/teachers/') }}" class="link-side"><span><i class="fa fa-file"></i>{{trans('home.home')}} لوحة المفاتيح</span></a>
				</li>
			@endif
            <li><a href="{{ url(App('urlLang').'account/ticket') }}" class="link-side"><span><i class="fa fa-sign-out"></i> {{trans('home.demande_aide')}}</span></a></li>
            <li><a href="{{ url(App('urlLang').'account/desactive') }}" class="link-side"><span><i class="fa fa-sign-out"></i>{{trans('home.close_account')}} </span></a></li>
            <li><a href="{{ url(App('urlLang').'logout') }}" class="link-side"><span><i class="fa fa-sign-out"></i> {{trans('home.logout')}}</span></a></li>
        </ul>
    </div>
</div>