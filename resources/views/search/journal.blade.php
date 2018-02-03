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
	@if (isset($isOdd))
		<section class="search_result container">
			<div class="row">
				<div class="col-md-12">
					<h2>{{$type}}</h2>
				</div>
			</div>
			<div class="row">
				@if ($journalsCount>20)
					<div class="col-md-8">Результат 1 - 20 из {{$journalsCount}}</div>
				@else
					<div class="col-md-8">Результат 1 - {{$journalsCount}}</div>

				@endif
				
				<div class="col-md-4">
					<div class="search_result_pages">
						
						@php ($pagesCount = $journalsCount/20)	
						@for ($i = 1; $i < $pagesCount; $i++)
							<a href="#">{{$i}}</a>
						@endfor
						<!-- <a href="#">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#">5</a> -->
					</div>
				</div>
			</div>

		</section>
	@endif
	<section class="article_container container">
	
	@if (isset($isOdd))
		@if ($isOdd==0)
			<!-- Четное количество журналов -->
			
			@for ($i = 0; $i < $journalsCount; $i++)	
				<div class="row">
					@include('parts.journal-search-item')
					@php (++$i)
					@include('parts.journal-search-item')
				</div>

			@endfor
		@else
			<!-- Нечетное число журналов -->

			@for ($i = 0; $i < $journalsCount; $i++)
				@if ($i==count($journals)-1)
					<div class="row">
						@include('parts.journal-search-item')
					</div>
				@else
					<div class="row">
						@include('parts.journal-search-item')
						@php (++$i)
						@include('parts.journal-search-item')
					</div>
				@endif
				
			@endfor

		@endif
		<form class="showArticlesInJournalForm" action="/show/journal" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="id" id="id">
		</form>
	@endif
	<br>
	


	</section>
@endsection

@section('modal')

@endsection

@section('script')

	

	<!-- FancyBox -->
	<script src="{{asset('libs/fancybox/jquery.fancybox.pack.js')}}"></script>

	<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'></script>

@endsection