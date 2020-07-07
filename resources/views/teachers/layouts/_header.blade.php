<header class="header">
    <a href="{{url('/teachers')}}" class="logo">
        <img src="{{asset('assets/admin/img/logo.png')}}" alt="Logo" style="height: 70px;width: 120px;">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <?php
        	
			function humanTiming1 ($time)
			{
			    $time = time() - $time; // to get the time since that moment
			    $time = ($time<1)? 1 : $time;
			    $tokens = array (
			        31536000 => 'year',
			        2592000 => 'month',
			        604800 => 'week',
			        86400 => 'day',
			        3600 => 'hour',
			        60 => 'minute',
			        1 => 'second'
			    );
			
			    foreach ($tokens as $unit => $text) {
			        if ($time < $unit) continue;
			        $numberOfUnits = floor($time / $unit);
			        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
			    }
			
			}
        ?> 
         
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <?php
                $teacher = Auth::guard("teachers")->user();
                ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="livicon" data-name="bell" data-loop="true" data-color="#e9573f" data-hovercolor="#e9573f" data-size="28"></i>
                        <span class="label label-warning">{{ $teacher->unreadNotifications()->count() }}</span>
                    </a>
                    <ul class=" notifications dropdown-menu">
                        <li class="dropdown-title">
                            <span class="bold">{{ $teacher->unreadNotifications()->count() }} pending</span> notifications
                            <a href="{{ url('teachers/notifications') }}">view all</a>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($teacher->unreadNotifications as $notification)
                                    @include("common.notifications.".snake_case(class_basename($notification->type)))
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('assets/admin/img/authors/avatar3.jpg')}}" width="35" class="img-circle img-responsive pull-left" height="35" alt="riot">
                        <div class="riot">
                            <div>
                                {{$teacher->full_name_ar}}
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            @if(!empty(Auth::guard("teachers")->user()->image))
                                <img src="{{asset('uploads/kcfinder/upload/image/admins/'.Auth::guard("teachers")->user()->image)}}" class="img-responsive img-circle" alt="{{Auth::guard('teachers')->user()->name}}">
                            @else
                                <img src="{{asset('assets/admin/img/authors/avatar3.jpg')}}" class="img-responsive img-circle" alt="{{Auth::guard('teachers')->user()->name}}">
                            @endif
                            <p class="topprofiletext">{{Auth::guard("teachers")->user()->name}}</p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="{{url('/teachers/profile')}}">
                                <i class="livicon" data-name="user" data-s="18"></i> My Profile
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            <a href="{{url('/teachers/profile')}}">
                                <i class="livicon" data-name="gears" data-s="18"></i> Account Settings
                            </a>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{url('teachers/home/lock')}}">
                                    <i class="livicon" data-name="lock" data-s="18"></i> Lock
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{url('/teachers/logout')}}">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
