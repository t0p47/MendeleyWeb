<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "AdminLTE Dashboard" }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta property="og:image" content="path/to/image.jpg">
    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">
 
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
	
	
	@yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="wrapper">

    <!-- Header -->
    @include('header_mendeley')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="container">
            <!-- Your Page Content Here -->
            @yield('content')
        </div><!-- /.content -->
    </div><!-- /.content-wrapper -->

    

    <!-- Footer -->
    @include('footer_mendeley')
	
	@yield('modal')

</div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <link rel="stylesheet" href="{{asset('css/main.min.css')}}">

    <!-- SiteRootUrl -->
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
    </script>

    <script src="{{asset('js/all.js')}}"></script>

    <!-- Design scripts -->
    <!-- <script src="{{asset('js/design.js')}}"></script> -->

    <!-- OwlCarouser -->
    <!-- <script src="{{asset('libs/OwlCarousel/owl-carousel/owl.carousel.min.js')}}"> --></script>

@yield('script')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>