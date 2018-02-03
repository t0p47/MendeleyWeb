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
  <!-- Select2 -->
  <link rel="stylesheet" href=" {{asset('/bower_components/adminLTE/plugins/select2/select2.min.css')}}">


@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transactions</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<table id="users-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>User_id</th>
                <th>Type</th>
				<th>Amount</th>
				<th>Details</th>
				<th>IP</th>
				<th>Created_at</th>
				<th>Updated_at</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>User_id</th>
                <th>Type</th>
				<th>Amount</th>
				<th>Details</th>
				<th>IP</th>
				<th>Created_at</th>
				<th>Updated_at</th>
            </tr>
        </tfoot>
        <tbody>
			@foreach($transactions as $transaction)
				<tr>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->id}}</a></td>
					<td><a class="user-get" href="/user_data/{{$transaction->user_id}}">{{$transaction->user->name}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->type}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->amount}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->details}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->ip}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->created_at}}</a></td>
					<td><a class="transaction-edit" data-toggle="modal" data-target="#edittransaction" data-id="{{$transaction->id}}" data-amount="{{$transaction->amount}}" data-userid="{{$transaction->user_id}}">{{$transaction->updated_at}}</a></td>
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

<div class="modal fade" id="edittransaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit transaction</h4>
      </div>
      <div class="modal-body">
        @include('forms.edit-transaction')
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
	<!-- Select2 -->
	<script src=" {{asset('/bower_components/adminLTE/plugins/select2/select2.full.min.js')}}"></script>
	
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
			
			//Initialize Select2 Elements
			$(".select2").select2();
		
		} );
		
		
	</script>
	
	<script type='text/javascript'>
		$(document).ready(function() {
			var id;
			var amount;
			var user_id;
			$('.transaction-edit').click(function(){
				id = $(this).attr('data-id');
				amount = $(this).attr('data-amount');
				user_id = $(this).attr('data-userid');
				$('#id').val(id);
				$('#edittransaction #amount').val(amount);
				$('#user_id').val(user_id);
				var act = "transaction/delete/"+id;
				$('#delete-transaction').attr('action',act);
			});
			
		} );
	</script>
	
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
	
@endsection