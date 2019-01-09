<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

		@yield('css')

		<title>{{ $title ?? 'GEMAH' }}</title>
	</head>
	<body>
		@include("web._includes.navbar")
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-2 d-none d-xl-block text-center">
					@include("web._includes.sidebar")
					@if(View::hasSection('sidebar'))
						<div class="col-12">
							<hr>
							@yield("sidebar")
						</div>
					@endif
				</div>
				<div class="col-12 col-xl-10">
					@include("web._includes.flash")
					@yield("content")
				</div>
			</div>
		</div>

		<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/poppers.min.js') }}"></script>
		@yield("scripts")
	</body>
</html>