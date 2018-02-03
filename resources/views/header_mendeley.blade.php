<header class="top_header">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<div class="logo">
						<a href="@if(Auth::guard('admin_user')->user())
									{{ url('/admin_home') }}
								@else
									{{ url('/home') }}
								@endif"><img src="{{asset('img/logo.png')}}" alt="logo"></a>
					</div>

				</div>


				<div class="col-md-7">
						<ul class="top_menu">
							<li class="active"><a href="@if(Auth::guard('admin_user')->user())
									{{ url('/admin_home') }}
								@else
									{{ url('/home') }}
								@endif">Главная</a></li>
							<li><a href="/journal/search-page">Журналы</a></li>
							<li><a href="/mendeley-library/{{ Auth::user()->id }}">Библиотека</a></li>
							<li><a href="#">Карьера</a></li>
							<li><a href="#">Финансирование</a></li>
						</ul>
				</div>
				<div class="col-md-3">
					<ul class="top_right">
						<li>
							<button class="button search_panel_button">
								<i class="fa fa-search" aria-hidden="true"></i>
								Поиск
							</button>
						</li>
						<li class="button top-user-toggler">
							<a href="#">Alexey</a>
								<ul class="top-user-menu">
									<li class="user-header list-item">
										<img src="{{ asset('/bower_components/adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
			                            <p>
											@if(Auth::guard('admin_user')->user())
												{{ Auth::guard('admin_user')->user()->name }}
											@else
												{{ Auth::guard('web')->user()->name }}
											@endif
			                                
											<!--TODO: Think about Datetime to Nov. 2012 in blade or controller-->
			                                <small>Member since Nov. 2017</small>
			                            </p>
									</li>
									<li class="user-body list-item clearfix">
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
									<li class="user-footer list-item clearfix">
										<div class="pull-left">
			                                <a class="button" href=" @if(Auth::guard('admin_user')->user())
															{{ url('/admin_home') }}
														@else
															{{ url('/home') }}
														@endif " class="btn btn-default btn-flat">Профиль</a>
			                            </div>
			                            <div class="pull-right">
			                                <a class="button" href=" @if(Auth::guard('admin_user')->user())
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
						<li class="hidden-md hidden-lg">
							<button class="top_menu_button"><i class="fa fa-bars" aria-hidden="true"></i></button>
						</li>
					</ul>
				</div>
			</div>
		</div>
</header>
@section('search_panel')
<section class="search_panel">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul>
					<li class="active-tab">Статьи</li>
					<li>Автор</li>
					<li>Группа</li>
					<li>Поддержка</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="search_form">
					<form action="" id="search_form_send">
							<i class="fa fa-search" aria-hidden="true"></i>
							<input type="text" name="search_query">
							<button type="submit" class="search_button">Поиск</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection