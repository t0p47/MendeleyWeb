<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="article_item">
		<div class="row">
			<div class="col-md-8 col-xs-9">
				<h3><a href="#">{{$journals[$i]->title}}</a></h3>
			</div>
			<!-- <div class="col-md-4 col-xs-3">
				<div class="article_container_stats">
					<ul class="horizontal-list">
						<li>
							<p class="text-center">4</p>
							<p class="stats_text">Читают</p>
						</li>
						<li>
							<p class="text-center">6</p>
							<p class="stats_text">Цитируют</p>
						</li>
					</ul>
				</div>
			</div> -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<ul>
					<li><a href="{{$journals[$i]->artOneId}}">{{$journals[$i]->articleOne}}</a></li>
					<li><a href="{{$journals[$i]->artTwoId}}">{{$journals[$i]->articleTwo}}</a></li>
					<li><a href="{{$journals[$i]->artThreeId}}">{{$journals[$i]->articleThree}}</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<a class="button showArticlesInJournalLink" data-id="{{$journals[$i]->id}}">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<span>Просмотреть журнал</span>
				</a>
			</div>
		</div>
	</div>
</div>