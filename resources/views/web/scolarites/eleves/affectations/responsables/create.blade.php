@extends('web._includes._master')
@php($title = "Création d'un responsable et affectation a {$eleve->nom} {$eleve->prenom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.responsables.index"])
			Création d'un responsable et affectation a {{ "{$eleve->nom} {$eleve->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form id="form" class="mb-3" action="{{ route("web.scolarites.eleves.affectations.responsables.store", [$eleve]) }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.departement", ["academies" => $academies])
				@endcomponent

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						<option value="M.">M</option>
						<option value="Mme">Mme</option>
						<option value="M./Mme">M./Mme</option>
					</select>
				</div>

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: SMITH"])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: SMITH"])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "email", "type" => "email", "placeholder" => "Ex: john@smith.fr"])
					Adresse E-Mail
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex: 04 77 81 41 00"])
					Téléhpone
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "adresse", "placeholder" => "Ex: 11 rue des Docteurs Charcot"])
					Adresse
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "code_postal", "placeholder" => "Ex: 42100"])
					Code postal
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "ville", "placeholder" => "Ex: Saint-Etienne"])
					Ville
				@endcomponent

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success js-submit">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection


@component("web._includes.components.modals.duplicate")
	@slot("type")
		Le responsable
	@endslot
@endcomponent

@section("scripts")

	<script>
		$(`.js-submit`).on(`click`, (e) => {
			e.preventDefault()

			let nom = $(`#nom`).val()
			let prenom = $(`#prenom`).val()

			if (nom !== "" && prenom !== "") {
				$.get(`/api/responsables?nom=${nom}&prenom=${prenom}`).then((results) => {
					if (results.length >= 1) {
						// Un élève du même nom/prénom existe déjà
						$(`#modal`).modal()
					} else {
						$(`#form`).submit()
					}
				}).catch(console.error)
			}
		})

		$(`.js-force-submit`).on(`click`, (e) => {
			e.preventDefault()

			$(`#form`).submit()
		})
	</script>

@endsection