@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.etablissements.index"])
			Création d'un établissement
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.etablissements.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations générales</span>
					<hr>

					<div class="form-group">
						<label for="nom">Nom</label>
						<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Lycée Simone Weil" value="{{ old("nom") }}" required>
					</div>

					<div class="form-group">
						<label class="optional" for="type_etablissement_id">Type</label>
						<select id="type_etablissement_id" class="form-control" name="type_etablissement_id">
							<option value="">Choisissez un type d'établissement</option>
							@foreach($types as $type)
								@if(old("type_etablissement_id") === $type->id)
									<option value="{{ $type->id }}" selected>{{ "{$type->libelle}" }}</option>
								@else
									<option value="{{ $type->id }}">{{ "{$type->libelle}" }}</option>
								@endif
							@endforeach
						</select>
					</div>


					<div class="form-group">
						<label for="id">Code</label>
						<input id="id" class="form-control" name="id" type="text" placeholder="Ex: ..." value="{{ old("id") }}" required>
					</div>

					<div class="form-group">
						<label for="degre">Degré</label>
						<input id="degre" class="form-control" name="degre" type="text" placeholder="Ex: ..." value="{{ old("degre") }}" required>
					</div>

					<div class="form-group">
						<label for="regime">Régime</label>
						<input id="regime" class="form-control" name="regime" type="text" placeholder="Ex: ..." value="{{ old("regime") }}" required>
					</div>
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de localisation</span>
					<hr>

					@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("departement_id")])
					@endcomponent

					<div class="form-group">
						<label for="ville">Ville</label>
						<input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Paris, Saint-Etienne, ..." value="{{ old("ville") }}" required>
					</div>

					<div class="form-group">
						<label for="code_postal">Code Postal</label>
						<input id="code_postal" class="form-control" name="code_postal" type="text" placeholder="Ex: 42100" value="{{ old("code_postal") }}" required>
					</div>

					<div class="form-group">
						<label for="adresse">Adresse</label>
						<input id="adresse" class="form-control" name="adresse" type="text" placeholder="Ex: 11 Rue des Docteurs Charcot" value="{{ old("adresse") }}" required>
					</div>
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de contact</span>
					<hr>

					<div class="form-group">
						<label for="telephone">Téléphone</label>
						<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ old("telephone") }}" required>
					</div>

					<div class="form-group">
						<label class="optional" for="enseignant_id">Enseignant Référent</label>
						<select id="enseignant_id" class="form-control" name="enseignant_id">
							<option value="">Sélectionnez un enseignant</option>
							@foreach($enseignants as $enseignant)
								@if(old("enseignant_id") === $enseignant->id)
									<option value="{{ $enseignant->id }}" selected>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</option>
								@else
									<option value="{{ $enseignant->id }}">{{ "{$enseignant->nom} {$enseignant->prenom}" }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection
