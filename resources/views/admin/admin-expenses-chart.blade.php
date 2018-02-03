@extends('layouts.admin_template')

@section('styles')

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/plugins/morris/morris.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('/bower_components/adminLTE/dist/css/skins/_all-skins.min.css')}}">
  

@endsection

@section('content')	

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Line Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="line-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>

@endsection

@section('script')


<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src=" {{asset('/bower_components/adminLTE/plugins/morris/morris.min.js')}}"></script>
<!-- FastClick -->
<script src=" {{asset('/bower_components/adminLTE/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src=" {{asset('/bower_components/adminLTE/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src=" {{asset('/bower_components/adminLTE/dist/js/demo.js')}}"></script>
<!-- page script -->
<script>
  $(function () {
    "use strict";

    

    // LINE CHART
    var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: [
        {y: '2012-05-24', item1: 2666},
        {y: '2012-05-25', item1: 2778},
        {y: '2012-05-26', item1: 4912},
        {y: '2012-05-27', item1: 3767},
        {y: '2012-05-28', item1: 6810},
        {y: '2012-05-29', item1: 5670},
        {y: '2012-05-30', item1: 4820},
        {y: '2012-05-31', item1: 15073},
        {y: '2012-06-01', item1: 1087},
        {y: '2012-06-02', item1: 8432}
      ],
      xkey: 'y',
      ykeys: ['item1'],
      labels: ['Item 1'],
      lineColors: ['#3c8dbc'],
      hideHover: 'auto'
    });

    
	
	
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


@endsection
