@extends('web._includes._master')
@php($title = "Édition de {$responsable->nom} {$responsable->prenom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.responsables.index"])
			Édition de {{ "{$responsable->nom} {$responsable->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.responsables.update", [$responsable]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				@component("web._includes.components.departement", ["academies" => $academies, "id" => $responsable->departement_id])
				@endcomponent

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						@if($responsable->civilite == "M.")
							<option selected value="M.">M</option>
							<option value="Mme">Mme</option>
							<option value="M./Mme">M/Mme</option>
						@elseif($responsable->civilite == "Mme")
							<option value="M.">M</option>
							<option selected value="Mme">Mme</option>
							<option value="M./Mme">M/Mme</option>
						@else
							<option value="M.">M</option>
							<option value="Mme">Mme</option>
							<option selected value="M./Mme">M/Mme</option>
						@endif
					</select>
				</div>

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: SMITH", "value" => $responsable->nom])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: SMITH", "value" => $responsable->prenom])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "email", "type" => "email", "placeholder" => "Ex: john@smith.fr", "value" => $responsable->email])
					Adresse E-Mail
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex: 04 77 81 41 00", "value" => $responsable->telephone])
					Téléphone
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "adresse", "placeholder" => "Ex: 11 rue des Docteurs Charcot", "value" => $responsable->adresse])
					Adresse
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "code_postal", "placeholder" => "Ex: 42100", "value" => $responsable->code_postal])
					Code postal
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "ville", "placeholder" => "Ex: Saint-Etienne", "value" => $responsable->ville])
					Ville
				@endcomponent

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.responsables.destroy", "id" => $responsable])
		@slot("name")
			{{ "{$responsable->nom} {$responsable->prenom}" }}
		@endslot
	@endcomponent

@endsection
