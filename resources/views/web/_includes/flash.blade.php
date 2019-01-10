@if ($errors->any())
	@if (count($errors) > 1)
		<div class="alert alert-danger">
			<b>Plusieurs erreurs se sont produites lors de l'exécution de votre requête</b>: <br>
			<ul>

				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@else
		<div class="alert alert-danger">
			<b>Une erreur s'est produite lors de l'exécution de votre requête</b>: <br>
			<ul class="mb-0">
				<li>{{ $errors->first() }}</li>
			</ul>
		</div>
	@endif
@endif



@if (Session::has("success"))
	<div class="alert alert-success">
		<p class="mb-0">{{ Session::get("success") }}</p>
	</div>
@endif