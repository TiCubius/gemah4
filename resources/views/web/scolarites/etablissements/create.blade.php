@extends('web._includes._master')
@php($title = "Création d'un établissement")

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
						<label for="type_etablissement_id">Type</label>
						<select id="type_etablissement_id" class="form-control" name="type_etablissement_id" required>
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


					@component("web._includes.components.input", ["optional" => true, "name" => "id", "placeholder" => "Ex : 0420044V"])
						Code
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "degre", "placeholder" => "Ex : Secondaire"])
						Degré
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "regime", "placeholder" => "Ex : Privé / Public"])
						Régime
					@endcomponent
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de localisation</span>
					<hr>

					@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("departement_id")])
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "adresse", "placeholder" => "Ex : 11 rue des Docteurs Charcots"])
						Adresse
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "code_postal", "placeholder" => "Ex : 42100"])
						Code Postal
					@endcomponent
					
					@component("web._includes.components.input", ["name" => "ville", "placeholder" => "Ex : Saint-Etienne"])
						Ville
					@endcomponent
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de contact</span>
					<hr>

					@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex : 04 77 81 41 00"])
						Téléphone
					@endcomponent

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
