@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.etablissements.index"])
			Édition de {{ $etablissement->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.etablissements.update", [$etablissement->id]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations générales</span>
					<hr>

					<div class="form-group">
						<label for="nom">Nom</label>
						<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Lycée Simone Weil" value="{{ $etablissement->nom }}" required>
					</div>

					<div class="form-group">
						<label for="type">Type</label>
						<input id="type" class="form-control" name="type" type="text" placeholder="Ex: ..." value="{{ $etablissement->type }}" required>
					</div>


					<div class="form-group">
						<label for="id">Code</label>
						<input id="id" class="form-control" name="id" type="text" placeholder="Ex: ..." value="{{ $etablissement->id }}" required>
					</div>

					<div class="form-group">
						<label for="degre">Degré</label>
						<input id="degre" class="form-control" name="degre" type="text" placeholder="Ex: ..." value="{{ $etablissement->degre }}" required>
					</div>

					<div class="form-group">
						<label for="regime">Régime</label>
						<input id="regime" class="form-control" name="regime" type="text" placeholder="Ex: ..." value="{{ $etablissement->regime }}" required>
					</div>
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de localisation</span>
					<hr>

					<div class="form-group">
						<label for="academie_id">Académie</label>
						<select id="academie_id" class="form-control" name="academie_id" required>
							<option value="">Sélectionnez une académie</option>
							@foreach($academies as $academie)
								@if($etablissement->academie_id === $academie->id)
									<option value="{{ $academie->id }}" selected>{{ $academie->nom }}</option>
								@else
									<option value="{{ $academie->id }}">{{ $academie->nom }}</option>
								@endif
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="ville">Ville</label>
						<input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Paris, Saint-Etienne, ..." value="{{ $etablissement->ville }}" required>
					</div>
					<div class="form-group">
						<label for="code_postal">Code Postal</label>
						<input id="code_postal" class="form-control" name="code_postal" type="text" placeholder="Ex: 42100" value="{{ $etablissement->code_postal }}" required>
					</div>
					<div class="form-group">
						<label for="adresse">Adresse</label>
						<input id="adresse" class="form-control" name="adresse" type="text" placeholder="Ex: 11 Rue des Docteurs Charcot" value="{{ $etablissement->adresse }}" required>
					</div>
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de contact</span>
					<hr>

					<div class="form-group">
						<label for="telephone">Téléphone</label>
						<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ $etablissement->telephone }}" required>
					</div>

					<div class="form-group">
						<label for="enseignant_id">Enseignant Référent</label>
						<select id="enseignant_id" class="form-control" name="enseignant_id">
							<option value="">Sélectionnez un enseignant</option>
							@foreach($enseignants as $enseignant)
								@if($etablissement->enseignant_id === $enseignant->id)
									<option value="{{ $enseignant->id }}" selected>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</option>
								@else
									<option value="{{ $enseignant->id }}">{{ "{$enseignant->nom} {$enseignant->prenom}" }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>


				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'établissement</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'établissement</button>
				</div>
			</form>
		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.etablissements.destroy", "id" => $etablissement->id])
		@slot("name")
			{{ $etablissement->nom }}
		@endslot
	@endcomponent

@endsection
