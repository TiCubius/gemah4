@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.types.index"])
			Création d'un Type Matériel
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.types.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom du type</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="domaine">Domaine Matériel</label>
					<select id="domaine" class="form-control" name="domaine" required>
						<option value="" hidden>Sélectionner un Domaine</option>
						@foreach($domaines as $domaine)
							<option value="{{ $domaine->id }}">{{ $domaine->nom }}</option>
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer le type</button>
				</div>
			</form>
		</div>

	</div>
@endsection
