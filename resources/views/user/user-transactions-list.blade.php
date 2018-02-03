@extends('layouts.admin_template')

@section('styles')


  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">


@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<table id="users-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
				<th>Amount</th>
				<th>Created_at</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
				<th>Amount</th>
				<th>Created_at</th>
            </tr>
        </tfoot>
        <tbody>
			@foreach($transactions as $transaction)
				
				<tr>
					<td>{{$transaction->amount}}</td>
					<td>{{$transaction->created_at}}</td>
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

@section('script')

	<!-- DataTables -->
	<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
	
	<script type='text/javascript'>
		$(document).ready(function() {
			$('#users-table').DataTable();
		} );
	</script>
	
@endsection