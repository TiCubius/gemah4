<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ public_path("assets/css/bootstrap.css") }}">
		<link rel="stylesheet" href="{{ public_path('assets/css/app.css') }}">
		@yield('css')

		<title>{{ $title ?? 'GEMAH' }}</title>
	</head>
	<body>
		@include('emails._includes.navbar')
		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-12">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>