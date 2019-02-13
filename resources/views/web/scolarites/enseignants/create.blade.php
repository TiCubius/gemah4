@extends('web._includes._master')
@php($title = "Création d'un enseignant")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.enseignants.index"])
			Création d'un enseignant
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.enseignants.store") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.departement", ["academies" => $academies])
				@endcomponent

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						<option value="M.">M</option>
						<option value="Mme">Mme</option>
					</select>
				</div>

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex : SMITH"])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex : John"])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "email", "placeholder" => "Ex : john@smith.fr"])
					Adresse E-Mail
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex : 04 77 81 41 00"])
					Téléphone
				@endcomponent

				@hasPermission("enseignants/create")
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
				@endHas
			</form>
		</div>

	</div>
@endsection
