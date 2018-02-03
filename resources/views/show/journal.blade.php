@extends('layouts.mendeley_master')

@section('search_panel')
	<p>No search panel</p>
@overwrite


@section('styles')

@endsection


@section('content')
	<section class="search_bar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="search_form">
						<form action="{{ route('JournalSearch') }}" id="search_form_send" method="POST">
								<i class="fa fa-search" aria-hidden="true"></i>
								<input type="text" name="search_query">
								{{ csrf_field() }}
								<button type="submit" class="search_button">Поиск</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
		<section class="search_result container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="text-center">{{$journal[0]->title}}</h2>
					<p>Год: {{$currentYear}}</p>
				</div>
			</div>
			<div class="row">
				
			</div>

		</section>
	<section class="article_container container">
	
	@if (isset($isOdd))
		@if ($isOdd==0)
			<!-- Четное количество статей -->
			
			@for ($i = 0; $i < $articlesCount; $i++)	
				<div class="row">
					@include('parts.article-search-item')
					@php (++$i)
					@include('parts.article-search-item')
				</div>

			@endfor
		@else
			<!-- Нечетное число статей -->

			@for ($i = 0; $i < $articlesCount; $i++)
				@if ($i==$articlesCount-1)
					<div class="row">
						@include('parts.article-search-item')
					</div>
				@else
					<div class="row">
						@include('parts.article-search-item')
						@php (++$i)
						@include('parts.article-search-item')
					</div>
				@endif
			@endfor
		@endif
	@endif
	<br>
	
	<section class="bottom_fixed_instrument">
		<ul class="horizontal-list">
			<li><a href="">Выделить все статьи</a></li>
			<li><a href="">Снять выделение</a></li>
			<li><a href="">Выпуски по годам:</a></li>
			@if (isset($years))
				@foreach($years as $year)
					<li><a class="selectYearLink" data-id="{{$jid}}" data-year="{{$year->year}}">{{$year->year}}</a></li>
				@endforeach
			@endif
			<form class="selectYearForm" action="/show/journal" method="POST">
				<input type="hidden" name="year" id="year">
				<input type="hidden" name="id" id="id">
				{{ csrf_field() }}
			</form>
		</ul>
	</section>

	</section>
@endsection

@section('modal')

@endsection

@section('script')

	<!-- FancyBox -->
	<script src="{{asset('libs/fancybox/jquery.fancybox.pack.js')}}"></script>

	<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>

@endsection