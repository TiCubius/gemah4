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
			<ul>
				<li>{{ $errors->first() }}</li>
			</ul>
		</div>
	@endif
@endif