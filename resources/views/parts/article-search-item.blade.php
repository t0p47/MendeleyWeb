<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="article_item">
		<div class="row">
			<div class="col-md-8 col-xs-9">
				<h3><a href="#">{{$articles[$i]->title}}</a></h3>
			</div>
			<div class="col-md-4 col-xs-3">
				<div class="article_container_stats">
					<ul class="horizontal-list">
						<li>
							<p class="text-center">{{$articles[$i]->takescount}}</p>
							<p class="stats_text">Читают</p>
						</li>
						<li>
							<p class="text-center">6</p>
							<p class="stats_text">Цитируют</p>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{$articles[$i]->authors}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{$articles[$i]->journal_id}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button data-id="{{$articles[$i]->id}}" class="add_to_library">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<span>Сохранить в библиотеку</span>
				</button>
			</div>
		</div>
	</div>
</div>