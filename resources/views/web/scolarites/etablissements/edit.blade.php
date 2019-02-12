@extends('web._includes._master')
@php($title = "Édition de {$etablissement->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.etablissements.index"])
			Édition de {{ $etablissement->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.etablissements.update", [$etablissement]) }}" method="POST">
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
						<label for="type_etablissement_id">Type</label>
						<select id="type_etablissement_id" class="form-control" name="type_etablissement_id">
							<option value="">Choisissez un type d'établissement</option>
							@foreach($types as $type)
								@if($etablissement->type_etablissement_id === $type->id)
									<option value="{{ $type->id }}" selected>{{ "{$type->libelle}" }}</option>
								@else
									<option value="{{ $type->id }}">{{ "{$type->libelle}" }}</option>
								@endif
							@endforeach
						</select>
					</div>


					@component("web._includes.components.input", ["optional" => true, "name" => "id", "placeholder" => "Ex : 0420044V", "value" => $etablissement->id])
						Code
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "degre", "placeholder" => "Ex : Secondaire", "value" => $etablissement->degre])
						Degré
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "regime", "placeholder" => "Ex : Privé / Public", "value" => $etablissement->regime])
						Régime
					@endcomponent
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de localisation</span>
					<hr>

					@component('web._includes.components.departement', ['academies' => $academies, 'id' => $etablissement->departement_id])
					@endcomponent

					@component("web._includes.components.input", ["name" => "ville", "placeholder" => "Ex : Saint-Etienne", "value" => $etablissement->ville])
						Ville
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "code_postal", "placeholder" => "Ex : 42100", "value" => $etablissement->code_postal])
						Code Postal
					@endcomponent

					@component("web._includes.components.input", ["optional" => true, "name" => "adresse", "placeholder" => "Ex : 11 rue des Docteurs Charcots", "value" => $etablissement->adresse])
						Adresse
					@endcomponent
				</div>

				<div class="card card-body mb-3">
					<span class="text-uppercase">Informations de contact</span>
					<hr>

					@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex : 04 77 81 41 00", "value" => $etablissement->telephone])
						Téléphone
					@endcomponent

					<div class="form-group">
						<label class="optional" for="enseignant_id">Enseignant Référent</label>
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


				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.etablissements.destroy", "id" => $etablissement])
		@slot("name")
			{{ $etablissement->nom }}
		@endslot
	@endcomponent

@endsection
