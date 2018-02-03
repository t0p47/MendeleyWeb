@extends('layouts.admin_template')

@section('styles')


  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- <script type="text/javascript" src="{{asset('js/addJournalArticle.js')}}"></script> -->

  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

  <!-- Folders -->
  <link rel="stylesheet" href="{{asset('css/folders.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/datepicker/datepicker3.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/iCheck/all.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}">

@endsection

@section('content')

<!--<iframe src="http://www.onlineicttutor.com/wp-content/uploads/2016/04/pdf-at-iframe.pdf" width="100%" height="300"></iframe>-->

<!--<iframe src="/storage/6/guice.pdf" width="100%" height="65%"></iframe>-->

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Журнальные статьи</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
			<li class="dropdown">
				<a href="" class="dropdowb-toggle" data-toggle="dropdown" aria-expanded="false">
					<span>Добавить</span>
				</a>
				<ul class="dropdown-menu">
					<li>Добавить раз</li>
					<li>Добавить два</li>
				</ul>
			</li>
			<button id="btn-add" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addjournalarticle">Добавить статью</button>

			<button type="button" id="delete-selected-articles" class="btn btn-danger btn-lg disabled" data-toggle="modal" data-target="#deletejournalarticle">Удалить выбраные статьи</button>

			<form id="delete-selected-articles-form" action="/delete_articles" method="POST">
				<input type="hidden" name="articles" value="">
				{{csrf_field()}}
			</form>
			
				<table id="articles-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
            	<th width="4%"><input type="checkbox" id="all-top-checkboxes"></th>
                <th>Название</th>
                <th>Авторы</th>
                <th>Журнал</th>
            </tr>
        </thead>
        <tbody id="article-list">
        	<?php $iter=0; ?>
			@foreach($journalarticles as $article)
				<tr id="article-preview-data">
					<td><input type="checkbox" class="checkbox-select" checkbox-id="{{$iter}}" 
					data-id="{{$article->id}}"></td>
					<td><a class="user-edit curs-point" data-toggle="modal" data-target="#edituser" data-id="" data-name="" data-email="" data-ip="">{{$article->title}}</a></td>
					<td><a class="user-edit curs-point" data-toggle="modal" data-target="#edituser" data-id="" data-name="" data-email="" data-ip="">{{$article->authors}}</a></td>
					<td><a class="user-edit curs-point" data-toggle="modal" data-target="#edituser" data-id="" data-name="" data-email="" data-ip="">{{$article->journal_id}}</a></td>
					<td><a class="edit-article curs-point" data-toggle="modal" data-target="#editarticle"
					data-id="{{$article->id}}" data-title="{{$article->title}}" 
					data-authors="{{$article->authors}}" data-abstract="{{$article->abstract}}"
					data-journal="{{$article->journal_id}}" data-year="{{$article->year}}"
					data-volume="{{$article->volume}}" data-issue="{{$article->issue}}"
					data-pages="{{$article->pages}}" data-arxivid="{{$article->ArXivID}}"
					data-doi="{{$article->DOI}}" data-pmid="{{$article->PMID}}">Редактировать</a><br>
					<a class="delete-article-class curs-point" data-id="{{$article->id}}">Удалить</a>
					@if($article->filepath)
						<br><a class="read-pdf-class" data-filepath="{{$article->filepath}}">Читать PDF</a>
					@endif

					</td>
						


				</tr>
				<?php $iter++; ?>
			@endforeach
			
        </tbody>
    </table>



	<form id="read-pdf" action="/view-pdf" method="POST">
							<input id="read-pdf-input" type="hidden" name="path" value="">
							{{csrf_field()}}
						</form>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	  
@endsection

@section('modal')

<div class="modal fade" id="editarticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Редактирование статьи</h4>
      </div>
      <div class="modal-body">
        @include('forms.edit-journal-article')
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>


<!-- Add Journal Article Modal -->
<div class="modal fade" id="addjournalarticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Добавление статьи</h4>
      </div>
      <div class="modal-body">
        @include('forms.add-journal-article')
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>


<!-- Folder name select -->
<div class="modal fade" id="foldername" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        @include('forms.subfolder-name')
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>



@endsection

@section('side-links')

	<ul class="sidebar-menu">
        <li class="treeview">
          <a href="#" id="open-button">
            <i class="fa fa-share"></i> <span>Folders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
		{{ createTreeView($folders,0) }}

        </li>
    </ul>
    <!-- <form action="/library/addSubfolder" method="POST">
    	{{ csrf_field() }}
    	<input type="hidden" name="parent_id" value="1">
    	<input type="submit" value="Create folder">
    </form>-->
	
	<div id="contextMenu" class="dropdown clearfix">
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu"
		style="display: block;position: static;margin-bottom: 5px;">
			<li><a tabindex="1" href="#" data-toggle="modal" data-target="#foldername">Add subfolder...</a></li>
			<li><a tabindex="2" href="#" data-toggle="modal" data-target="#foldername">Rename</a></li>
			<li><a tabindex="3" href="#">Remove folder</a>
				<form action="/library/deleteFolder/12">
					{{csrf_field()}}
					<input type="submit" value="Удалить 7 папку">
				</form>
			</li>
		</ul>
	</div>

    <!-- <div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
      <li><a tabindex="-1" href="#">Action</a></li>
      <li><a tabindex="-1" href="#">Another action</a></li>
      <li><a tabindex="-1" href="#">Something else here</a></li>
      <li class="divider"></li>
      <li><a tabindex="-1" href="#">Separated link</a></li>
    </ul>
  </div> -->

@endsection

@section('script')

	<meta name="_token" content="{!! csrf_token() !!}" />
	<!-- DataTables -->
	<script src="{{asset('/bower_components/adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/bower_components/adminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
	<!-- InputMask -->
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.js')}}"></script>
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('/bower_components/adminLTE/plugins/select2/select2.full.min.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/bower_components/adminLTE/plugins/iCheck/icheck.min.js')}}"></script>
	
	<!-- Datatables buttons -->
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
	<script src="{{asset('/bower_components/pdfmake/build/pdfmake.min.js')}}"></script>
	<script src="{{asset('/bower_components/pdfmake/build/vfs_fonts.js')}}"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	
	<!-- Folders script -->
	<script type="text/javascript" src="{{asset('js/folders.js')}}"></script>
	
	<!-- AJAX Add journal article request -->
	<script type="text/javascript" src="{{asset('js/addJournalArticle.js')}}"></script>

	<!-- AJAX Delete journal article request -->
	<script type="text/javascript" src="{{asset('js/deleteJournalArticle.js')}}"></script>
	
	<script type="text/javascript">

	$(document).ready(function() {
		$('#articles-table').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'pdfHtml5',
				'copyHtml5',
				'excelHtml5',
				'csvHtml5'
			]
		} );

	} );

	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			//Money Euro
			$("[data-mask]").inputmask();
			
			//iCheck for checkbox and radio inputs
			$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			  checkboxClass: 'icheckbox_minimal-blue',
			  radioClass: 'iradio_minimal-blue'
			});
			//Red color scheme for iCheck
			$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			  checkboxClass: 'icheckbox_minimal-red',
			  radioClass: 'iradio_minimal-red'
			});
			//Flat red color scheme for iCheck
			$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			  checkboxClass: 'icheckbox_flat-green',
			  radioClass: 'iradio_flat-green'
			});
		});
	</script>
	
@endsection