@extends('web._includes._master')@php($title = "Édition de {$enseignant->nom} {$enseignant->prenom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.enseignants.index"])
			Édition de {{ "{$enseignant->nom} {$enseignant->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.enseignants.update", [$enseignant]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				@component("web._includes.components.departement", ["academies" => $academies])
				@endcomponent

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						@if($enseignant->civilite === "M.")
							<option value="M." selected>M.</option>
							<option value="Mme">Mme</option>
						@else
							<option value="M." selected>M.</option>
							<option value="Mme">Mme</option>
						@endif
					</select>
				</div>

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex : SMITH", "value" => $enseignant->nom])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex : John", "value" => $enseignant->prenom])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "email", "placeholder" => "Ex : john@smith.fr", "value" => $enseignant->email])
					Adresse E-Mail
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex : 04 77 81 41 00", "value" => $enseignant->telephone])
					Téléphone
				@endcomponent

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.enseignants.destroy", "id" => $enseignant])
		@slot("name")
			{{ "{$enseignant->nom} {$enseignant->prenom}" }}
		@endslot
	@endcomponent

@endsection
