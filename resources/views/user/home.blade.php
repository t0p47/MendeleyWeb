@extends('layouts.admin_template')

@section('content')
<div class="row">
	

	<!--<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">Библиотека</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">			  
				<a type="button" class="btn btn-info" href="library/{{ Auth::user()->id }}"> Моя библиотека </a>
			</div>
		  </div>
	  </div>-->

	  <div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">Поиск</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">	
				<a type="button" class="btn btn-info" href=" {{route('JournalArticleSearch')}}"> Поиск </a>
			</div>
			<!-- /.box-body -->
		  </div>
	  </div>

	  <div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">Журналы</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">			  
				<a type="button" class="btn btn-info" href="library/{{ Auth::user()->id }}"> Список журналов </a>
			</div>
			<!-- /.box-body -->
		  </div>
	  </div>


</div><!-- /.row -->

<script type='text/javascript'>
	$(document).ready(function() {
		var sum = 0;
		$('.dollar-btn').click(function(){
			var add = $(this).val();
			sum = parseInt(sum) + parseInt(add);
			$('#standart').val(sum);
		});
	} );
</script>

@endsection
