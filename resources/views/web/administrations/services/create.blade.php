@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Création d'un service
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Administration" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<input id="description" class="form-control" name="description" type="text" placeholder="Ex: Possède tout les droits sur l'application" value="{{ old("description") }}" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("department_id")])
				@endcomponent

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer le service</button>
				</div>
			</form>
		</div>

	</div>
@endsection
