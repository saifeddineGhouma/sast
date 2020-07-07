<!DOCTYPE html>
<html>
	
    <head>
        <meta charset="utf-8" />
        <title>Reset password</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	                    <div id="wrapper">	                                                
	                        <div id="login" class="animate form">
	                        	 <form method="POST" action="{{url('admin/password/reset') }}" autocomplete="on">
			    				 {!! csrf_field() !!}	 
			    				 <input type="hidden" name="token" value="{{ $token }}">                           
	                                <h3 class="black_bg">
	                                    <img src="{{asset('assets/admin/img/logo.jpg')}}" alt="">Reset your password</h3>
	                                    @if (session('status'))
								            <div class="alert alert-success">
								                {{ session('status') }}
								            </div>
								        @endif 
	                                <p>
	                                    reset your password .
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
	                                <p>
	                                    <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
	                                        Password
	                                    </label>
	                                    <input id="password" name="password" required type="password" placeholder="eg. X8df!90EO" />
	                                     @if ($errors->has('password'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('password') }}</strong>
		                                    </span>
		                                @endif
	                                </p>
	                                <p>
	                                    <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
	                                        Password Confirmation
	                                    </label>
	                                    <input id="password" name="password_confirmation" required type="password" placeholder="eg. X8df!90EO" />
	                                    @if ($errors->has('password_confirmation'))
							                <span class="help-block">
							                    <strong>{{ $errors->first('password_confirmation') }}</strong>
							                </span>
							            @endif
	                                </p>
	                                <p class="login button">
	                                    <input type="submit" value="Reset Password" class="btn btn-success" />
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

