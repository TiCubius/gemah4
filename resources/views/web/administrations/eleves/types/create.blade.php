@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Création d'un type d'élève
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.eleves.types.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Matériel" value="{{ old("Libellé") }}" required>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer le type d'élève</button>
				</div>
			</form>
		</div>

	</div>
@endsection
