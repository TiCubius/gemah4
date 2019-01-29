@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.etablissements.index"])
			Création d'un type d'établissement
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.types.etablissements.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: LYCEE POLYVALENT" value="{{ old("libelle") }}" required>
				</div>
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection
