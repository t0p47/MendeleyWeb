@extends('layouts.admin_template')

@section('styles')


  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

  
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


<div>Path: {{$path}}</div>
<iframe src="app/public/19/guice.pdf" width="100%" height="500px"></iframe>

@endsection

@section('script')

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
	
	<script type='text/javascript'>
		$(document).ready(function() {
			var id;
			var title;
			var authors;
			var abstract;
			var journal;
			var year;
			var volume;
			var issue;
			var pages;
			var arxivid;
			var doi;
			var pmid;

			$('.delete-article-class').click(function(){
				id = $(this).attr('data-id');
				var act = "/journalarticle/delete/"+id;
				$('#delete-article').attr('action',act);
				$('#delete-article').submit();
			});

			$('.edit-article').click(function(){
				id = $(this).attr('data-id');
				title = $(this).attr('data-title');
				authors = $(this).attr('data-authors');
				abstract = $(this).attr('data-abstract');
				journal = $(this).attr('data-journal');
				year = $(this).attr('data-year');
				volume = $(this).attr('data-volume');
				issue = $(this).attr('data-issue');
				pages = $(this).attr('data-pages');
				arxivid = $(this).attr('data-arxivid');
				doi = $(this).attr('data-doi');
				pmid = $(this).attr('data-pmid');

				$('#editarticle #id').val(id);
				$('#editarticle #title').val(title);
				$('#editarticle #authors').val(authors);
				$('#editarticle #abstract').val(abstract);
				$('#editarticle #journal').val(journal);
				$('#editarticle #year').val(year);
				$('#editarticle #volume').val(volume);
				$('#editarticle #issue').val(issue);
				$('#editarticle #pages').val(pages);
				$('#editarticle #ArXivID').val(arxivid);
				$('#editarticle #DOI').val(doi);
				$('#editarticle #PMID').val(pmid);

				var act = "/journalarticle/delete/"+id;
				$('#delete-article').attr('action',act);
			});
			
		} );

		/*$(document).ready(function() {
			var id;
			var name;
			var email;
			$('.user-edit').click(function(){
				id = $(this).attr('data-id');
				name = $(this).attr('data-name');
				email = $(this).attr('data-email');
				$('#user_id').val(id);
				$('#edituser #name').val(name);
				$('#edituser #email').val(email);
				var act = "user/delete/"+id;
				$('#delete-user').attr('action',act);
			});
			
		} );*/

	</script>
	
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