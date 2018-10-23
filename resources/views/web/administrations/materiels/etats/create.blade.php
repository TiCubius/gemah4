@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.index"])
			Création d'un État Matériel
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom de l'état matériel</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="E.g : Volé, Cassé" value="{{ old("nom") }}" required>
				</div>
				<div class="form-group">
					<label for="nom">Couleur de l'état matériel</label>
					<input id="nom" class="form-control" name="couleur" type="color" placeholder="couleur" value="{{ old("couleur") }}" required>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'état matériel</button>
				</div>
			</form>

		</div>
	</div>
@endsection
