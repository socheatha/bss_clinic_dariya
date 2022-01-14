<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{!! Auth::user()->module() !!} | Clinic</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
	@yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapses text-sm">
	@yield('print-area')

	<div class="wrapper" id="app">

			@include('layouts.top_menu')

			@include('layouts.sidebar')

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			@include('layouts.header')
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					
					@yield('content')
					
				</div><!-- /.container-fluid -->
				@include('components.dynamic_modal_content')
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		
	</div>
	<!-- ./wrapper -->

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/custom-js.js') }}"></script>
	@yield('js')
	<script src="{{ asset('js/global.js') }}"></script>
</body>
</html>
