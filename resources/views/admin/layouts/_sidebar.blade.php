
    <section class="sidebar  noprint">
        <div class="page-sidebar  sidebar-nav">

            <div class="clearfix"></div>
            <!-- BEGIN SIDEBAR MENU -->
            <ul id="menu" class="page-sidebar-menu">
                <li>
                    <a href="{{url('/admin')}}">
                        <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                        <span class="title">Dashboard</span>
                        <span class="fa arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="livicon" data-name="medal" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span class="title">Courses</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">                    	
                        <li>
                            <a href="{{url('/admin/categories')}}">
                                <i class="fa fa-angle-double-right"></i> Categories
                            </a>
                        </li> 
                        <li>
                            <a href="{{url('/admin/courses')}}">
                                <i class="fa fa-angle-double-right"></i> Courses
                            </a>
                        </li> 
                        <li>
                            <a href="{{url('/admin/packs')}}">
                                <i class="fa fa-angle-double-right"></i> Packs Courses
                            </a>
                        </li> 
                        <li>
                            <a href="{{url('/admin/orders')}}">
                                <i class="fa fa-angle-double-right"></i> Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/admin/forum')}}">
                                <i class="fa fa-angle-double-right"></i> Forums
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/admin/quizzes')}}">
                                <i class="fa fa-angle-double-right"></i> Quizzes
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/admin/quizzes?exam=1')}}">
                                <i class="fa fa-angle-double-right"></i> Exams
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/admin/videoexams')}}">
                                <i class="fa fa-angle-double-right"></i> Video Exams
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="livicon" data-name="medal" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span class="title">Books</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{url('/admin/books')}}">
                                <i class="fa fa-angle-double-right"></i> Books
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{url('/admin/reviews')}}">
                        <i class="livicon" data-name="like" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span>All Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/students-exams')}}">
                        <i class="livicon" data-name="medal" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                        <span class="title">Students Exams&Quizzes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="livicon" data-name="medal" data-c="#EF6F6C" data-hc="#EF6F6C" data-size="18" data-loop="true"></i>
                        <span class="title">Certificates</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{url('admin/certificates')}}">
                                <i class="fa fa-angle-double-right"></i> Certificates
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/students-certificates?manual=1')}}">
                                <i class="fa fa-angle-double-right"></i> Manual Students Certificates
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/students-certificates?manual=0')}}">
                                <i class="fa fa-angle-double-right"></i> Students Certificates
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/stage')}}">
                                <i class="fa fa-angle-double-right"></i> Students internship 
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/user_cpd')}}">
                                <i class="fa fa-angle-double-right"></i> Students Certificates  CPD
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/barcodes')}}">
                                <i class="fa fa-angle-double-right"></i> Barcodes
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="livicon" data-name="users" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span class="title">Members</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                    	@if(Auth::guard("admins")->user()->can("admins"))
	                        <li>
	                            <a href="{{url('admin/roles')}}">
	                                <i class="fa fa-angle-double-right"></i> Roles
	                            </a>
	                        </li>
	                        <li>
	                            <a href="{{url('admin/admins')}}">
	                                <i class="fa fa-angle-double-right"></i> Admins
	                            </a>
	                        </li>
	                    @endif
	                    @if(Auth::guard("admins")->user()->can("users"))
	                    	<li>
	                            <a href="{{url('admin/students')}}">
	                                <i class="fa fa-angle-double-right"></i> Students
	                            </a>
	                        </li>
	                        <li>
	                            <a href="{{url('admin/teachers')}}">
	                                <i class="fa fa-angle-double-right"></i> Teachers
	                            </a>
	                        </li>
	                        <li>
	                            <a href="{{url('admin/users')}}">
	                                <i class="fa fa-angle-double-right"></i> Users
	                            </a>
	                        </li>
	                        <li>
	                            <a href="{{url('admin/newsletter/subscribers')}}">
	                                <i class="fa fa-angle-double-right"></i> Newsletter Subscribers
	                            </a>
	                        </li>
	                   @endif	                    
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="livicon" data-name="gears" data-c="#EF6F6C" data-hc="#EF6F6C" data-size="18" data-loop="true"></i>
                        <span class="title">General</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{url('admin/menus')}}">
                                <i class="fa fa-angle-double-right"></i> Menus
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/pages')}}">
                                <i class="fa fa-angle-double-right"></i> Pages
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/news')}}">
                                <i class="fa fa-angle-double-right"></i> Publications
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/countries')}}">
                                <i class="fa fa-angle-double-right"></i> Countries
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/governments')}}">
                                <i class="fa fa-angle-double-right"></i> Governments
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/agents')}}">
                                <i class="fa fa-angle-double-right"></i> Agents
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/coupons')}}">
                                <i class="fa fa-angle-double-right"></i> Coupons
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/testimonials')}}">
                                <i class="fa fa-angle-double-right"></i> Testimonials
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/faq')}}">
                                <i class="fa fa-angle-double-right"></i> Faqs
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/invoice')}}">
                                <i class="fa fa-angle-double-right"></i> Invoices
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="livicon" data-name="table" data-c="#418BCA" data-hc="#418BCA" data-size="18" data-loop="true"></i>
                        <span class="title">System</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu">
                    	@if(Auth::guard("admins")->user()->can("admins"))
	                        <li>
	                            <a href="{{url('admin/settings/edit')}}">
	                                <i class="fa fa-angle-double-right"></i> Public settings
	                            </a>
	                        </li>
                        @endif
                        <li>
                            <a href="{{url('admin/notifications')}}">
                                <i class="fa fa-angle-double-right"></i> Notifications
                            </a>
                        </li>
                        <li> 
                            <a href="{{url('admin/historiques')}}">
                                <i class="fa fa-angle-double-right"></i> Historic
                            </a>
                        </li>
                        @if(Auth::guard("admins")->user()->can("users"))
	                        <li>
	                            <a href="{{url('admin/newsletter')}}">
	                                <i class="fa fa-angle-double-right"></i> Newsletter
	                            </a>
	                        </li>
	                        <li>
	                            <a href="{{url('admin/emailtemplates')}}">
	                                <i class="fa fa-angle-double-right"></i> Email Templates
	                            </a>
	                        </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="{{url('/admin/ticket')}}">
                        <i class="livicon" data-name="like" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span>Tickets</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('/admin/direct-order')}}">
                        <!-- <i class="livicon" data-name="like" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i> -->
                        <span>Mare order</span>
                    </a>
                </li>
                <!--li>
                    <a href="{{url('/admin/seo')}}">
                        <i class="livicon" data-name="like" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                        <span>SEO</span>
                    </a>
                </li-->
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </section>
    <!-- /.sidebar -->

