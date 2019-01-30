@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.services.create", "permission" => "administrations/services/create", "back" => "web.administrations.index"])
			Gestion des services
		@endcomponent

		<div class="col-12">
			@if($services->isEmpty())
				<div class="alert alert-warning">
					Aucun service n'est enregistré sur l'application
				</div>
			@else
				@component('web._includes.components.departement', ['academies' => $academies])
				@endcomponent

				<table id="services" class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Description</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($services as $service)
							<tr data-departement="{{ $service->departement_id }}">
								<td>{{ $service->nom }}</td>
								<td>{{ $service->description }}</td>
								<td>
									@hasPermission("administrations/services/edit")
									<a href="{{ route("web.administrations.services.edit", [$service]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
									</a>
									@endHas
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>

	</div>
@endsection

@section("scripts")
	<script>
		let forceService = function (departement_id) {

			// On obtient tout les services
			let allServices = document.querySelectorAll(`#services tbody tr`)
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