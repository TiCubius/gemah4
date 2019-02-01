@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.scolarites.enseignants.create", "permission" => "enseignants/create", "back" => "web.scolarites.index"])
			Gestion des enseignants référents
		@endcomponent


		<div class="col-12 mb-3">
			@if($latestCreated->isEmpty())
				{{-- Aucun enseignant n'est présent dans la BDD --}}

				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun enseignant n'est enregistré sur l'application
				@endcomponent
			@else
				<div class="row">
					{{-- Des enseignants existent sur l'application --}}

					<div class="col-12 @empty($enseignants) col-lg-6 @endempty">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}

							<div class="card-header gemah-bg-primary">Rechercher un enseignant</div>
							<div class="card-body">
								@component("web._includes.components.departement", ["optional" => true, "academies" => $academies, "id" => request("departement_id")])
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "nom", "placeholder" => "Ex: SMITH"])
									Nom
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "prenom", "placeholder" => "Ex: John"])
									Prénom
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "email", "placeholder" => "Ex: john.smith@exemple.fr"])
									Adresse E-Mail
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex: 01 23 45 67 89"])
									Téléphone
								@endcomponent

								<div class="d-flex justify-content-between">
									<a class="btn btn-outline-dark" href="{{ route("web.scolarites.enseignants.index") }}">Annuler la recherche</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($enseignants)
						<div class="col-6">
							{{-- Liste des derrniers enseignants créés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestCreated as $enseignant)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("enseignants/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.enseignants.edit", [$enseignant]) }}">Editer</a>
												@endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>


							{{-- Liste des derrniers enseignants modifiés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers modifiés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestUpdated as $enseignant)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("enseignants/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.enseignants.edit", [$enseignant]) }}">Editer</a>
												@endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					@else
						{{-- Il s'agit d'une recherche d'enseignants --}}

						<div class="col-12 mt-3">
							@component("web._includes.components.alert", ["type" => "success"])
								<b>Information(s) sur la recherche</b> <br>
								<ul class="mb-0">
									<li>
										Nombre d'enseignants: {{ count($enseignants) }}
									</li>
								</ul>
							@endcomponent
						</div>

						@if(count($enseignants) > 0)
							<div class="col-12 mt-3">
								<div class="table-responsive">
									<table id="table" class="table table-stripped">
										<thead class="gemah-bg-primary">
											<tr class="align-middle">
												<th class="align-middle">Nom</th>
												<th class="align-middle">Prénom</th>
												<th class="align-middle">Adresse E-Mail</th>
												<th class="align-middle">Telephone</th>
												<th class="align-middle" width="116px">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($enseignants as $enseignant)
												<tr>
													<td>{{ $enseignant->nom }}</td>
													<td>{{ $enseignant->prenom }}</td>
													<td>{{ $enseignant->email }}</td>
													<td>{{ $enseignant->telephone }}</td>
													<td>
														@hasPermission("enseignants/edit")
														<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.enseignants.edit", [$enseignant]) }}">Editer</a>
														@endHas
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif
					@endempty
				</div>
			@endif
		</div>
	</div>

@endsection

@section("scripts")
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}"
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 4},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection