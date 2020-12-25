<?php
$setting = App('setting');
$setting_trans = $setting->settings_trans(session()->get('locale'));
if(empty($setting_trans))
    $setting_trans = $setting->settings_trans('en');
?>
<div class="footer">
	<div class="container">

			{{-- <div class="row justify-content-center">
				<!-- <img src="{{asset('uploads/kcfinder/upload/image/'.$setting_trans->logo)}}"> -->
				<p>@lang('navbar.footerGCSS')</p>
			</div> --}}
			<div class="social_media">
                <div class="row justify-content-center">
				  @foreach(App('setting')->socials as $social)
                        <div class="col-1">
                                <div class="background">
                                        <div class="circle">
                                             <a href="{{ $social->link }}" target="_blank"><i class="{{ $social->font }}  " ></i></a>
                                        </div>
                                </div>
                        </div>
						 @endforeach
                       
                </div>
			</div>
		@php $textalgn = session()->get('locale') === "ar" ? "right" : "left" @endphp
		<div class="row" dir= {{ $dir }} style="text-align: {{ $textalgn }}"> 
		

			<div class="col-lg-4 col-md-4  col-sm-12 ">
				@if(Session::get("locale") == "ar")
					<ul class="website_category" style="text-align: {{ $textalgn }}">
						<?php
							$menuPos = App\MenuPos::find(3);
							$menu = $menuPos->menus()->first();
						?>
						@if(!empty($menu))
							{!! $menu->links("footer") !!}
						@endif
					</ul>
					<ul class="website_category " style="text-align: {{ $textalgn }}">
						<?php
							$menuPos = App\MenuPos::find(4);
							$menu = $menuPos->menus()->first();
						?>
						@if(!empty($menu))
							{!! $menu->links("footer") !!}
						@endif
					</ul> 
				@else
					<ul class="website_category " style="text-align: {{ $textalgn }}">
						<?php
							$menuPos = App\MenuPos::find(4);
							$menu = $menuPos->menus()->first();
						?>
						@if(!empty($menu))
							{!! $menu->links("footer") !!}
						@endif
					</ul> 
					<ul class="website_category" style="text-align: {{ $textalgn }}">
							<?php
								$menuPos = App\MenuPos::find(3);
								$menu = $menuPos->menus()->first();
							?>
							@if(!empty($menu))
								{!! $menu->links("footer") !!}
							@endif
					</ul>
				@endif

			</div>

			<div class="col-lg-4 col-md-4  col-sm-12 ">

				<div class="mail">
					<i class="fa fa-envelope"   style="color:#ffcb05" aria-hidden="true"></i>
					<span>{{ $setting->email }}</span>
				</div>
				<div class="phone">
					<i class="fa fa-phone"  style="color:#ffcb05" aria-hidden="true"></i>
					<span>{{ $setting->mobile }}</span>
				</div>
			</div>	
			<div class="col-lg-4 col-md-4 col-sm-6  feedback_footer ">
				<form class="newsletter-form" method="post">
					<div class="displayNewsletter" style="display: none;"></div>
					<div class="form-group"><i class="fa fa-envelope" style='font-size:14px;color:#ffcb05;'></i><span style="color:#ffcb05;font-size:18px;">  @lang('navbar.followUs')</span>
					<input class="form-control feedback_send newsletter-email" type="text" placeholder="@lang('navbar.tapeMailToFollow')">
					</div>
					<button data-loading-text="@lang('navbar.following')" class="subscribe">@lang('navbar.follow')</button>

				</form>

			
			</div>
		</div>
	</div>
</div>
<!-- End Footer -->

<!-- Start CopyRight -->
<div class="copyright">
	<p>@lang('navbar.footertext') </p>
</div>
<!-- End CopyRight -->


