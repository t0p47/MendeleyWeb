@extends('layouts.mendeley_master')

@section('styles')

<!-- FancyBox -->
<link rel="stylesheet" href="{{asset('libs/fancybox/jquery.fancybox.css')}}">

@endsection


@section('content')

<div id="my-page">
	<div id="my-header"></div>
	<div id="my-content">
		
		<div class="row">
			<div class="col-md-3">
				<div class="adding_toolbar"></div>
				<nav class="sidebar">

					<a class="button fancybox add-article-btn" href="#addJournalArticleID">Добавить</a>

					<ul class="sidebar-menu">
						<li class="treeview">
							<a href="#" id="open-button">
								<span>Библиотека</span>
							</a>
							<ul class="treeview-menu" style="display:none;">
								<li><a href="#" class="allarticles-btn"><i class="fa fa-university" aria-hidden="true"></i>Все статьи</a></li>
								<li><a href="#" class="my-articles-btn"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Мои статьи</a></li>
								<li><a href=""><i class="fa fa-plus" aria-hidden="true"></i>Недавно добавленные</a></li>
								<li><a href="" class="favorite-articles-btn"><i class="fa fa-star" aria-hidden="true"></i>Фаворит</a></li>
							</ul>
						</li>
						<li class="treeview treeview-exp">
							
							<a href="#" id="open-button">
								<span>Папки</span>
							</a>

							{{ createTreeView($folders,0) }}

						</li>
					</ul>

				</nav>
			</div>
			<div class="col-md-6">
				<div class="center_article_table">
					<div class="row">
						<div class="central_toolbar">
							<ul class="controller_toolbar horizontal-list">
								<li>
									<input id="allarticles" class="checkbox-styled" type="checkbox" />
									<label for="allarticles"></label>
								</li>
								<li>
									<button>
										Добавить
									</button>
								</li>
								<li>
									<button id="delete-article-btn">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
										<span>Удалить</span>
									</button>								
								</li>
								<li>
									<button>
										Export to MS Word
									</button>
								</li>
							</ul>
							<ul class="sort_toolbar">
								<li>
									Сортировка	
								</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div id="articles_list">
							<ul>

								@foreach($journalarticles as $article)
								<li data-id="{{$article->id}}">
									<span class="check_indicator">
										<input id="testarticles" class="checkbox-styled" type="checkbox" />
										<label for="testarticles"></label>
									</span>
									@if($article->favorite==1)
										<span class="favorite_indicator favorite_indicator_active">
									@else
										<span class="favorite_indicator">
									@endif
										<i class="fa fa-star" aria-hidden="true"></i>
									</span>
									<span class="read_indicator">

									</span>
									<span class="file_indicator" data-filepath="{{$article->filepath}}">
									@if($article->filepath!='')
										<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
									@endif
									</span>
									<h2 class="article_title">{{$article->title}}</h2>
									<p class="authorAndArticle">{{$article->authors}} В {{$article->journal_id}}</p>
									<span class="date_added">
										{{ date('j M', strtotime($article->created_at))}}
									</span>
								</li>
								@endforeach
							</ul>
							<form method="POST" id="pdf-form" action="/view-pdf">
								{{csrf_field()}}
								<input type="hidden" name="filepath">
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="collapse_handler">
					<a href="#">Show</a>
				</div>
				<div class="right_related_sidebar">
					
					<div class="no_article_selected">
						<p>Статья не выбрана</p>
					</div>
					<div id="related_tabs">
						<ul>
							<li><a href="#tabs-1">Редактировать</a></li>
							<li><a href="#tabs-2">Заметки</a></li>
						</ul>
						<div id="tabs-1">
							<section class="show_article_info">
								<section class="edit_article_tool">
									<a href="#" class="button edit_article_button">
										<i class="fa fa-pencil" aria-hidden="true"></i>
										Изменить
									</a>
								</section>
								<section class="article_info">
									<p>Название</p>
									<h2 class="article_title">TestName</h2>
									<ul class="article_authors">
										<li>AuthorName</li>
									</ul>
									<section class="article_details">
										<p class="article_journal">TestJournal</p>
										<p class="article_year">2007</p>
									</section>
								</section>
								<section class="article_abstract">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque tempore iste necessitatibus id asperiores quia possimus ab maxime nisi, odit est et ducimus rem, quo? Eveniet, nulla. Magni, ipsa provident.
									Consequatur ex maxime delectus ullam aperiam repudiandae! Voluptas eius asperiores aspernatur excepturi numquam ratione, quia perferendis. Accusantium dolores, delectus! Dignissimos quibusdam quo numquam perspiciatis error ullam praesentium inventore explicabo facere!
									Natus dicta id, et.
								</section>
								<a class="abstract_more_toggle" href="#">more</a>
								<a class="abstract_less_toggle" href="#">less</a>
								<!-- TODO:FileDrop -->
								<section class="sidebar_upload">
									<section id="zone10">
										<section>
											<iframe src="javascript:false" name="fd_2884" id="fd_2884" style="display: none;">
												
											</iframe>
											<form method="post" enctype="multipart/form-data" target="fd_2884" style="position: relative;">
												<input name="fd-callback" type="hidden">
												<input name="fd-file" class=" fd-file" type="file">
											</form>
										</section>
										<span class="legend">
											Drop a large file to see some progress...
										</span>

										<!-- You can also use <progress> tag of HTML5: -->
											<span class="progress">
												<span id="bar_zone10"></span>
											</span>
										</section>
									</section>
								</section>
								<section class="edit_article_info">
									<section class="edit_article_tool">
										<a href="#" class="button save_article_edit_button">
											<i class="fa fa-pencil" aria-hidden="true"></i>
											Сохранить
										</a>
										<a href="#" class="button close_article_edit_button">
											<i class="fa fa-pencil" aria-hidden="true"></i>
											Закрыть
										</a>
									</section>
									<section class="edit_article_form">
										<form action="">

											<input type="hidden" name="id" id="id">
											<input type="hidden" name="uid" id="uid" value="{{ Auth::user()->id }}">

											<label for="title">Название</label>
											<input type="text" name="title" id="title" required>

											<label for="authors">Авторы</label>
											<input type="text" name="authors" id="authors" required>

											<label for="abstract">Абстракт</label>
											<textarea name="abstract" id="abstract"></textarea>

											<p>Детали</p>

											<label for="journal_id">Журнал</label>
											<input type="text" name="journal_id" id="journal_id">

											<label for="year">Год</label>
											<input type="text" name="year" id="year">

											<label for="volume">Volume</label>
											<input type="text" name="volume" id="volume">

											<label for="issue">Issue</label>
											<input type="text" name="issue" id="issue">

											<label for="pages">Страницы</label>
											<input type="text" name="pages" id="pages">

											<p>Идентификаторы в каталогах</p>

											<label for="ArXivID">ArXivID</label>
											<input type="text" name="ArXivID" id="ArXivID">

											<label for="DOI">DOI</label>
											<input type="text" name="DOI" id="DOI">

											<label for="PMID">PMID</label>
											<input type="text" name="PMID" id="PMID">


										</form>
									</section>
								</section>
							</div>
							<div id="tabs-2">
								<p>Content for Tab 2</p>
							</div>
						</div>

					</div>




				</div>
			</div>
		</div>		

	</div>
	<div id="my-footer"></div>
</div>

@endsection

@section('modal')

<div id="contextMenu" class="dropdown clearfix">
	<ul class="dropdown-menu">
		<li><a tabindex="1" href="#addfolder" class="fancybox">Add subfolder...</a></li>
		<li><a tabindex="2" href="#renamefolder" class="fancybox">Rename</a></li>
		<li><a tabindex="3" href="#">Remove folder</a></li>
	</ul>
</div>

<div class="hidden">
	<form id="addfolder" autocomplete="off" method="POST">
		{{ csrf_field() }}
		<h3>Создать папку</h3>
		<input type="text" name="name" id="name" placeholder="Название папки" required />
		<input type="hidden" name="isrename" id="isrename" value='0'>
		<button class="button">Создать</button>
	</form>

	<form id="renamefolder" autocomplete="off" method="POST">
		{{ csrf_field() }}
		<h3>Переименовать папку</h3>
		<input type="text" name="name" id="name" placeholder="Название папки" required />
		<input type="hidden" name="isrename" id="isrename" value='1'>
		<button class="button">Переименовать</button>
	</form>

	@include('forms.add-journal-article')
</div>

@endsection

@section('script')

<!-- POST Token -->
<meta name="_token" content="{!! csrf_token() !!}" />

<!-- 	TestStart -->

<!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css" rel="stylesheet" /> -->

<!-- TestEnd -->

<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>

<!-- AdminLTE App -->
<script src="{{ asset ('/bower_components/adminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>

<!-- FancyBox -->
<script src="{{asset('libs/fancybox/jquery.fancybox.pack.js')}}"></script>

<!-- FileDrop -->
<script src="{{asset('js/filedrop.js')}}"></script>

<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].onclick = function(){
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}
		}
	}
</script>

@endsection