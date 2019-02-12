@extends("web._includes._master")
@php($title = "Gestion des responsables")

@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.responsables.create", "permission" => "responsables/create", "back" => "web.index"])
			Gestion des responsables
		@endcomponent


		<div class="col-12 mb-3">
			@if($latestCreated->isEmpty())
				{{-- Aucun responsable n'est présent dans la BDD --}}

				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun responsable n'est enregistré sur l'application
				@endcomponent
			@else
				<div class="row">
					{{-- Des responsables existent sur l'application --}}

					<div class="col-12 mb-3 @empty($responsables) col-lg-6 @endempty">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}

							<div class="card-header gemah-bg-primary">Rechercher un responsable</div>
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
									<a class="btn btn-outline-dark" href="{{ route("web.responsables.index") }}">Annuler la recherche</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($responsables)
						<div class="col-12 col-lg-6">
							{{-- Liste des derrniers responsables créés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestCreated as $responsable)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$responsable->nom} {$responsable->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("responsables/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.show", [$responsable]) }}">
													<i class="fas fa-info-circle"></i>
													Détails
												</a>
												@endHas
												@hasPermission("responsables/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.edit", [$responsable]) }}">
													Éditer
												</a>
												@endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>


							{{-- Liste des derrniers élèves modifiés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers modifiés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestUpdated as $responsable)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$responsable->nom} {$responsable->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("responsables/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.show", [$responsable]) }}">
													<i class="fas fa-info-circle"></i>
													Détails
												</a>
												@endHas
												@hasPermission("responsables/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.edit", [$responsable]) }}">
													Éditer
												</a>
												@endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					@else
						{{-- Il s'agit d'une recherche de responsables --}}

						<div class="col-12 mt-3">
							@component("web._includes.components.alert", ["type" => "success"])
								<b>Information(s) sur la recherche</b> <br>
								<ul class="mb-0">
									<li>
										Nombre de responsables: {{ count($responsables) }}
									</li>
								</ul>
							@endcomponent
						</div>

						@if(count($responsables) > 0)
							<div class="col-12 mt-3">
								<div class="table-responsive">
									<table id="table" class="table table-stripped">
										<thead class="gemah-bg-primary">
											<tr class="align-middle">
												<th class="align-middle">Nom</th>
												<th class="align-middle">Prénom</th>
												<th class="align-middle">Adresse E-Mail</th>
												<th class="align-middle">Téléphone</th>
												<th class="align-middle" width="116px">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($responsables as $responsable)
												<tr>
													<td>{{ $responsable->nom }}</td>
													<td>{{ $responsable->prenom }}</td>
													<td>{{ $responsable->email}}</td>
													<td>{{ $responsable->telephone }}</td>
													<td class="btn-group">
														@hasPermission("responsables/show")
														<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.show", [$responsable]) }}">
															<i class="fas fa-info-circle"></i>
															Détails
														</a>
														@endHas
														@hasPermission("responsables/show")
														<a class="btn btn-sm btn-outline-primary" href="{{ route("web.responsables.edit", [$responsable]) }}">
															Éditer
														</a>
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
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
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