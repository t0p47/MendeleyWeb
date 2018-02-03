<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/bower_components/adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
					@if(Auth::guard('admin_user')->user())
						{{ Auth::guard('admin_user')->user()->name }}
					@else
						{{ Auth::guard('web')->user()->name }}
					@endif 
				</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
<span class="input-group-btn">
  <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
            </div>
        </form>

        <a href='https://play.google.com/store/apps/details?id=com.t0p47.sciencelib&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Доступно в Google Play' src='https://play.google.com/intl/en_us/badges/images/generic/ru_badge_web_generic.png' width="230" /></a>

        <a href="/download_windows">Скачать ScienceLib для Windows</a>

        <!-- /.search form -->

        <!-- Sidebar Menu -->
        @yield('side-links')
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>