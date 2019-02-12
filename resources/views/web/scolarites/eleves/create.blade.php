@extends('web._includes._master')
@php($title = "Création d'un élève")

@section('content')

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Création d'un élève
		@endcomponent

		<div class="col-12">
			<form id="form" class="mb-3" action="{{ route("web.scolarites.eleves.store") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: SMITH"])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: Jane"])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "date_naissance", "placeholder" => "Ex: 07/01/2019", "type" => "date"])
					Date de naissance
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "classe", "placeholder" => "Ex: 1e"])
					Classe
				@endcomponent

				@component('web._includes.components.departement', ['academies' => $academies])
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "code_ine", "placeholder" => "Ex: 0000000000X"])
					Code INE
				@endcomponent

				<div class="custom-control custom-checkbox">
					<input name="joker" id="joker" class="custom-control-input" type="checkbox" checked>
					
					<label class="custom-control-label" for="joker">
						Joker
					</label>
				</div>

				@hasPermission("eleves/create")
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success js-submit">Créer</button>
				</div>
				@endHas
			</form>
		</div>
	</div>

@endsection

@component("web._includes.components.modals.duplicate")
	@slot("type")
		L'élève
	@endslot
@endcomponent

@section("scripts")

	<script>
		$(`.js-submit`).on(`click`, (e) => {
			e.preventDefault()

			let nom = $(`#nom`).val()
			let prenom = $(`#prenom`).val()

			if (nom !== "" && prenom !== "") {
				$.get(`/api/scolarites/eleves?nom=${nom}&prenom=${prenom}`).then((results) => {
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