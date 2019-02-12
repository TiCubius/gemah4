@extends('web._includes._master')
@php($title = "Création d'un utilisateur")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.utilisateurs.index"])
			Création d'un utilisateur
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.utilisateurs.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: DOE"])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: John"])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "identifiant", "placeholder" => "Ex: jdoe"])
					Identifiant
				@endcomponent

				@component("web._includes.components.input", ["type" => "email", "name" => "email", "placeholder" => "Ex: john.doe@exemple.fr"])
					Adresse E-Mail
				@endcomponent

				<div class="custom-control custom-checkbox mb-3">
					<input id="reception_email" class="custom-control-input" name="reception_email" type="checkbox" checked>
					<label class="custom-control-label" for="reception_email">Recevoir les notifications</label>
				</div>

				@component("web._includes.components.input", ["type" => "password", "name" => "password", "placeholder" => "Veuillez rentrer un mot de passe"])
					Mot de passe
				@endcomponent

				@component("web._includes.components.input", ["type" => "password", "name" => "password_confirmation", "placeholder" => "Veuillez confirmer votre mot de passe"])
					Confirmation du mot de passe
				@endcomponent

				@component('web._includes.components.departement', ['academies' => $academies])
				@endcomponent

				<div class="form-group">
					<label for="service_id">Service</label>
					<select id="service_id" class="form-control" name="service_id" required>
						<option hidden>Sélectionner un Service</option>
						@foreach($services as $service)
							<option data-departement="{{ $service->departement_id }}" value="{{ $service->id }}">{{ $service->nom }}</option>
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection

@section("scripts")
	<script>
		let forceService = function (departement_id) {

			// On obtient tout les services
			let allServices = document.querySelectorAll(`#service_id option`)
			allServices.forEach((service) => {
				// On cache le service
				service.classList.add('d-none')

				// Si le service appartient au département, on l'affiche
				if (service.dataset.departement === departement_id) {
					service.classList.remove('d-none')
				} else {
					// Sinon, si le service est sélectionné
					// on le déselectionne
					if (service.selected) {
						service.selected = false
					}
				}
			})
		}

		// On ajoute l'évenement
		document.querySelector(`#departement_id`).addEventListener('change', function (e) {
			let departement_id = this.value
			forceService(departement_id)
		})

		// On force l'évènment au lancement de la page
		document.querySelector(`#departement_id`).dispatchEvent(new Event(`change`))

	</script>
@endsection