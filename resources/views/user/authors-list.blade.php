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
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Поиск</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<table id="users-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Имя</th>
				<th>Количество выложенных статей</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Имя</th>
				<th>Количество выложенных статей</th>
            </tr>
        </tfoot>
        <tbody>
			@foreach($authors as $author)
				
				<tr>
					<td><a href="library/{{ $author->id }}" data-id="{{$author->id}}" data-name="{{$author->name}}">{{$author->name}}</a></td>
					<td><a href="library/{{ $author->id }}" data-id="{{$author->id}}" data-name="{{$author->name}}">{{$author->postcount}}</a></td>
				</tr>
				
			@endforeach
        </tbody>
    </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	  
@endsection

@section('modal')

<div class="modal fade" id="createusers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <div class="modal-body">
        <!--@include('forms.register')-->
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>

<div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>

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
	
	
	<script type="text/javascript">

	$(document).ready(function() {
		$('#users-table').DataTable( {
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
	
	<script type='text/javascript'>
		$(document).ready(function() {
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