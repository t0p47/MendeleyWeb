@extends('layouts.admin_template')

@section('styles')


  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
  
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href=" {{asset('/bower_components/adminLTE/plugins/datepicker/datepicker3.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href=" {{asset('/bower_components/adminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}">


@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Expenses</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createexpense">Add expense</button>
			
				<table id="expenses-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Created_at</th>
                <th>Details</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Amount</th>
                <th>Created_at</th>
                <th>Details</th>
            </tr>
        </tfoot>
        <tbody>
			@foreach($expenses as $expense)
				
				<tr>
					<td><a class="expense-edit" data-toggle="modal" data-target="#editexpense" data-id="{{$expense->id}}" data-amount="{{$expense->amount}}" data-details="{{$expense->details}}">{{$expense->amount}}</a></td>
					<td><a class="expense-edit" data-toggle="modal" data-target="#editexpense" data-id="{{$expense->id}}" data-amount="{{$expense->amount}}" data-details="{{$expense->details}}">{{$expense->created_at}}</a></td>
					<td><a class="expense-edit" data-toggle="modal" data-target="#editexpense" data-id="{{$expense->id}}" data-amount="{{$expense->amount}}" data-details="{{$expense->details}}">{{$expense->details}}</a></td>
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

<div class="modal fade" id="createexpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add expense</h4>
      </div>
      <div class="modal-body">
        @include('forms.create-expense')
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>

<div class="modal fade" id="editexpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit expense</h4>
      </div>
      <div class="modal-body">
        @include('forms.edit-expense')
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
	<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
	<!-- bootstrap time picker -->
	<script src=" {{asset('/bower_components/adminLTE/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
	<!-- bootstrap datepicker -->
	<script src=" {{asset('/bower_components/adminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	
	<!-- Datatables buttons -->
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
	<script src="{{asset('/bower_components/pdfmake/build/pdfmake.min.js')}}"></script>
	<script src="{{asset('/bower_components/pdfmake/build/vfs_fonts.js')}}"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	
	<script type='text/javascript'>
		$(document).ready(function() {
			
			//Date picker
			$('#datepicker').datepicker({
			  autoclose: true
			});
			
			//Timepicker
			$(".timepicker").timepicker({
			  showInputs: false
			});
			
		} );
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			var id;
			var amount;
			var details;
			$('.expense-edit').click(function(){
				id = $(this).attr('data-id');
				amount = $(this).attr('data-amount');
				details = $(this).attr('data-details');
				$('#id').val(id);
				$('#editexpense #amount').val(amount);
				$('#editexpense #details').val(details);
				var act = "expense/delete/"+id;
				$('#delete-expense').attr('action',act);
			});
			
		} );
	</script>
	
	<script type="text/javascript">

	$(document).ready(function() {
		$('#expenses-table').DataTable( {
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
	
@endsection