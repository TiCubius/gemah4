<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/gemah.css') }}">
		@yield('css')

		<title>{{ "GEMAH - " . $title ?? "Index" }}</title>
	</head>

	<body>
		@include("web._includes.navbar")

		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-2 d-none d-xl-block text-center">
					<div class="sticky-top">

						@include("web._includes.sidebar")
						@if(View::hasSection('sidebar'))
							<div class="col-12">
								<hr>
								@yield("sidebar")
							</div>
						@endif
					</div>
				</div>

				<div class="col-12 col-xl-10">
					@include("web._includes.flash")
					@yield("content")
				</div>
			</div>
		</div>

		<script src="{{ asset('assets/js/fontawesome.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/js/poppers.min.js') }}"></script>
		<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<script type="application/javascript">
			$('input[type="file"]').change(function (e) {
				let fileName = e.target.files[0].name
				$(`label[for=${e.target.name}]`).html(fileName)
			})
		</script>

		<script>
			// Remise a l'ancienne valeur des différents selects
			// Si le formulaire a été envoyé en GET
			let queries = new URLSearchParams(window.location.search)
			document.querySelectorAll(`select`).forEach((select) => {
				let name = select.name
				let value = queries.get(name)

				select.querySelectorAll(`option`).forEach((option) => {
					if (option.value === value) {
						option.selected = true
					}
				})
			})
		</script>
		@yield("scripts")
	</body>
</html>