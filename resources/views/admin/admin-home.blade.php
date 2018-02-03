@extends('layouts.admin_template')

@section('content')	
<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">Work with users</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">
				@if($admin->ip_restrict=='yes')
					<a href=" {{url('/mass_ip_restrict')}} " onclick="event.preventDefault();
                                document.getElementById('disable-form').submit();" class="btn btn-success">Disable ip restriction</a>
								<form id="disable-form" action="{{url('/mass_ip_restrict')}}"  method="POST" style="display: none;">
                                    {{ csrf_field() }}
									
									<input type="hidden" name="ip" value="{{$admin->ip}}">
									<input type="hidden" name="ip_restrict" value="no">
                                </form>
				
				
				@elseif($admin->ip_restrict=='no')
					<a type="button" class="btn btn-danger" data-toggle="modal" data-target="#ip_restrict">Enable ip restriction</a>
				@endif
				<a type="button" class="btn btn-info" href=" {{ url('users_list') }} ">Show users list</a>
			</div>
			<!-- /.box-body -->
		  </div>	  
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">Expenses</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">
			  <a type="button" class="btn btn-info" href=" {{ route('allExpenseList')}} ">Show expenses list</a>
			  <a type="button" class="btn btn-info" href=" {{ route('allExpenseChart')}} ">Show expenses chart</a>
			</div>
			<!-- /.box-body -->
		  </div>	  
	</div>
	
	<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title">User's transactions</h3>

			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fa fa-times"></i></button>
			  </div>
			</div>
			<div class="box-body">			  
				<a type="button" class="btn btn-info" href="{{route('allTransList')}}"> User transactions list </a>
				<a type="button" class="btn btn-info" href="{{route('allTransChart')}}"> User transactions chart </a>
				
				<a type="button" class="btn btn-info" href="{{url('busy_days')}}">What days are busy with most transactions</a>
				<a type="button" class="btn btn-info" href="{{url('busy_hours')}}">What hours of the day are busy with most transactions</a>
			</div>
			<!-- /.box-body -->
		  </div>
	  </div>
	
</div>
@endsection

@section('modal')

<div class="modal fade" id="ip_restrict" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <div class="modal-body">
        @include('forms.mass-ip-restrict')
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

	<!-- InputMask -->
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.js')}}"></script>
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
	<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){

			//Money Euro
			$("[data-mask]").inputmask();
		});
	</script>


@endsection
