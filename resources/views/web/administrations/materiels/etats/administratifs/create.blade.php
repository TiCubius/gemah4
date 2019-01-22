@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.administratifs.index"])
			Création d'un état administratif matériel
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.administratifs.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Volé" value="{{ old("libelle") }}" required>
				</div>

				<div class="form-group">
					<label for="couleur">Couleur</label>
					<input id="couleur" class="form-control" name="couleur" type="color" value="{{ old("couleur") }}" required>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'état administratif matériel</button>
				</div>
			</form>

		</div>
	</div>
@endsection
