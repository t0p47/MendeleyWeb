@extends('layouts.admin_template')

@section('styles')

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/morris/morris.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href=" {{asset('/bower_components/adminLTE/plugins/select2/select2.min.css')}}">
    <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
  

@endsection

@section('content')	
	
		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Line Chart</h3>
			  
				<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
					<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
					<span></span> <b class="caret"></b>
				</div>
			  
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
			
			@if(isset($datas))
				<div class="box-body chart-responsive">
				  <div class="chart" id="line-chart" style="height: 300px;"></div>
				</div>
				<!-- /.box-body -->
			@endif
          </div><!-- /.box-body -->
	
		  <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transactions</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			@if(isset($datas))
				<table id="transactions-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
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
						
							@foreach($datas as $data)
								
								<tr>
									<td>{{$data['count']}}</td>
									<td>{{$data['created_at']}}</td>
								</tr>
								
							@endforeach
						
					</tbody>
				</table>
			@else
				
			 	<p>No transactions in this period of time.</p>
			
			@endif
            </div>
			<form method="POST" id="formId" action="{{ url('/busy_days') }}">
				{{csrf_field()}}
				<input type="hidden" id="start_date" name="start_date">
				<input type="hidden" id="end_date" name="end_date">
			</form>
            <!-- /.box-body -->
          </div>

@endsection

@section('script')

<!-- DataTables -->
<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src=" {{asset('/bower_components/adminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src=" {{asset('/bower_components/adminLTE/plugins/morris/morris.min.js')}}"></script>
<!-- FastClick -->
<script src=" {{asset('/bower_components/adminLTE/plugins/fastclick/fastclick.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('/bower_components/adminLTE/plugins/select2/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('/bower_components/adminLTE/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('/bower_components/adminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>

<!-- Datatables buttons -->
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/bower_components/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('/bower_components/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>



<!-- page script -->
<script>
  $(function () {
    "use strict";
	@if(isset($datas))
    
		 var line = new Morris.Line({
		  element: 'line-chart',
		  resize: true,
		  data: [
			
				@foreach($datas as $data)
			  
					{y: '{{$data['created_at']}}:00:00', item1: {{$data['count']}} },
					
				  
				@endforeach
			
			
		  ],
		  xkey: 'y',
		  //TODO: В следующие две строки вставлять users для сравнения графиков
		  ykeys: ['item1'],
		  labels: ['Item 1'],
		  
		  xLabels: 'hour',
		  lineColors: ['#3c8dbc'],
		  hideHover: 'auto'
		});

    @endif
	
	
	/*var nReloads = 0;
	function data(offset) {
	  var ret = [];
	  for (var x = 0; x <= 360; x += 10) {
		var v = (offset + x) % 360;
		ret.push({
		  x: x,
		  y: Math.sin(Math.PI * v / 180).toFixed(4),
		  z: Math.cos(Math.PI * v / 180).toFixed(4)
		});
	  }
	  return ret;
	}
	var graph = Morris.Line({
		element: 'line-chart',
		data: data(0),
		xkey: 'x',
		ykeys: ['y', 'z'],
		labels: ['sin()', 'cos()'],
		parseTime: false,
		ymin: -1.0,
		ymax: 1.0,
		hideHover: true
	});
	function update() {
	  nReloads++;
	  graph.setData(data(5 * nReloads));
	  $('#reloadStatus').text(nReloads + ' reloads');
	}
	setInterval(update, 100);*/
	
  });
</script>


<script type="text/javascript">
$(function() {

    var start = moment().subtract(2, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		//alert('Start - '+start.format('YYYY-MM-DD HH:mm')+', '+'end'+end.format('YYYY-MM-DD HH:mm'));
		//alert(start.format('YYYY-MM-DD HH:mm'));
		$("#start_date").val(start.format('YYYY-MM-DD'));
		$("#end_date").val(end.format('YYYY-MM-DD'));
		$("#formId").submit();
    }
	
	

    $('#reportrange').daterangepicker({
		
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    //cb(start, end);
    
});
</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#transactions-table').DataTable( {
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
