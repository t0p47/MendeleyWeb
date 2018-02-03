<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
	<a href=" @if(Auth::guard('admin_user')->user())
												{{ url('/admin_home') }}
											@else
												{{ url('/home') }}
											@endif " class="logo"><b>Admin</b>LTE</a>
	

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
						<!--TODO: Needs a photo?-->
                        <!--<img src="{{ asset('/bower_components/adminLTE/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>-->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"> 
								@if(Auth::guard('admin_user')->user())
									{{ Auth::guard('admin_user')->user()->name }}
								@else
									{{ Auth::guard('web')->user()->name }}
								@endif 
						</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset('/bower_components/adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
                            <p>
								@if(Auth::guard('admin_user')->user())
									{{ Auth::guard('admin_user')->user()->name }}
								@else
									{{ Auth::guard('web')->user()->name }}
								@endif
                                
								<!--TODO: Think about Datetime to Nov. 2012 in blade or controller-->
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href=" @if(Auth::guard('admin_user')->user())
												{{ url('/admin_home') }}
											@else
												{{ url('/home') }}
											@endif " class="btn btn-default btn-flat">Профиль</a>
                            </div>
                            <div class="pull-right">
                                <a href=" @if(Auth::guard('admin_user')->user())
												{{ url('/admin_logout') }}
											@else
												{{ url('/logout') }}
											@endif " onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
								<form id="logout-form" action=" @if(Auth::guard('admin_user')->user())
												{{ url('/admin_logout') }}
											@else
												{{ url('/logout') }}
											@endif " method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
													 
													 
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>