@extends('web._includes._master')
@php($title = "Création d'un responsable")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.responsables.index"])
			Création d'un responsable
		@endcomponent

		<div class="col-12">
			<form id="form" class="mb-3" action="{{ route("web.responsables.index") }}" method="POST">
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

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: SMITH" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ old("prenom") }}" required>
				</div>


				<div class="form-group">
					<label class="optional" for="email">Adresse E-Mail</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ old("email") }}">
				</div>

				<div class="form-group">
					<label class="optional" for="telephone">Téléphone</label>
					<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ old("telephone") }}">
				</div>


				<div class="form-group">
					<label class="optional" for="code_postal">Code postal</label>
					<input id="code_postal" class="form-control" name="code_postal" type="text" placeholder="Ex: 42100" value="{{ old("code_postal") }}">
				</div>

				<div class="form-group">
					<label class="optional" for="ville">Ville</label>
					<input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Saint-Etienne" value="{{ old("ville") }}">
				</div>

				<div class="form-group">
					<label class="optional" for="adresse">Adresse</label>
					<input id="adresse" class="form-control" name="adresse" type="text" placeholder="Ex: 11 Rue des Docteurs Charcot" value="{{ old("adresse") }}">
				</div>

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