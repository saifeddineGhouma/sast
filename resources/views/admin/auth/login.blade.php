<!DOCTYPE html>
<html>
	
    <head>
        <meta charset="utf-8" />
        <title>Log in</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	    <!-- global level css -->
	    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
	    <!-- end of global level css -->
	    <!-- page level css -->
	    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/pages/login.css')}}" />
	    <!-- end of page level css -->
        {{-- <link rel="shortcut icon" href="favicon.ico" /> --}}
    </head>
    <!-- END HEAD -->

    <body>
    	<div class="container">
	        <div class="row vertical-offset-100">
	            <div class="col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
	                <div id="container_demo">
	                    <a class="hiddenanchor" id="tologin"></a>
	                    <a class="hiddenanchor" id="toforgot"></a>
	                    <div id="wrapper">
	                        <div id="login" class="animate form">
	                        	<form class="form-signin"  method="post" action="{{url('admin/login')}}" autocomplete="on">
            					{{csrf_field()}}
	                                <h3 class="black_bg">
	                                    <img src="{{asset('assets/admin/img/logo.png')}}" alt="">
	                                    <br>Log in</h3>
										@if (session('status'))
											<div class="alert alert-success">
												{{ session('status') }}
											</div>
										@endif


										@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
	<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif



									<p>
	                                    <label style="margin-bottom:0px;" for="login" class="uname"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
	                                        E- mail or Username	                                      
	                                    </label>
	                                    <input id="username" name="login" value="{{ old('login') }}" required type="text" placeholder="username or e-mail" />
	                                   {{--   @if ($errors->has('login'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('login') }}</strong>
		                                    </span>
		                                @endif --}}
		                                {{--  @if ($errors->has('username'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('username') }}</strong>
		                                    </span>
		                                @endif --}}
	                                </p>
	                                <p>
	                                    <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
	                                        Password
	                                    </label>
	                                    <input id="password" name="password" required type="password" placeholder="eg. X8df!90EO" />
	                                    {{--  @if ($errors->has('password'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('password') }}</strong>
		                                    </span>
		                                @endif --}}
	                                </p>
	                                <p class="keeplogin">
	                                    <input type="checkbox" name="remember" id="loginkeeping" value="loginkeeping" />
	                                    <label for="loginkeeping">Keep me logged in</label>
	                                </p>
	                                <p class="login button">
	                                    <input type="submit" value="Login" class="btn btn-success" />
	                                </p>
	                                <p class="change_link">
	                                    <a href="#toforgot">
	                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Forgot password</button>
	                                    </a>
	                                </p>
	                            </form>
	                        </div>	                        
	                        <div id="forgot" class="animate form">
	                        	 <form method="POST" action="{{ url('/admin/password/email') }}" class="forget-form">
			    				 {!! csrf_field() !!}
	                                <h3 class="black_bg">
	                                    <img src="{{asset('assets/admin/img/logo.jpg')}}" alt="josh logo">Password</h3>
	                                    @if (session('status'))
								            <div class="alert alert-success">
								                {{ session('status') }}
								            </div>
								        @endif 
	                                <p>
	                                    Enter your email address below and we'll send a special reset password link to your inbox.
	                                </p>
	                                <p>
	                                    <label style="margin-bottom:0px;" for="emailsignup1" class="youmai">
	                                        <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
	                                        Your email
	                                    </label>
	                                    <input id="emailsignup1" name="email" required type="email" value="{{ $email or old('email') }}" placeholder="your@mail.com" />
	                                    @if ($errors->has('email'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('email') }}</strong>
							                </span>
							            @endif
	                                </p>
	                                <p class="login button">
	                                    <input type="submit" value="Send" class="btn btn-success" />
	                                </p>
	                                <p class="change_link">
	                                    <a href="#tologin" class="to_register">
	                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Back</button>
	                                    </a>
	                                </p>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
        
        <!-- global js -->
	    <script src="{{asset('assets/admin/js/jquery-1.11.3.min.js')}}" type="text/javascript"></script>
	    <!-- Bootstrap -->
	    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
	    <!--livicons-->
	    <script src="{{asset('assets/admin/vendors/livicons/minified/raphael-min.js')}}" type="text/javascript"></script>
	    <script src="{{asset('assets/admin/vendors/livicons/minified/livicons-1.4.min.js')}}" type="text/javascript"></script>
	   <script src="{{asset('assets/admin/js/josh.js')}}" type="text/javascript"></script>
	    <script src="{{asset('assets/admin/js/metisMenu.js')}}" type="text/javascript"> </script>
	    <script src="{{asset('assets/admin/vendors/holder/holder.js')}}" type="text/javascript"></script>
	    <!-- end of global js -->
    </body>

</html>