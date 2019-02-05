@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.scolarites.eleves.create", "permission" => "eleves/create", "back" => "web.scolarites.index"])
			Gestion des élèves
		@endcomponent


		<div class="col-12 mb-3">
			@if($latestCreated->isEmpty())
				{{-- Aucun élève n'est présent dans la BDD --}}

				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun élève n'est enregistré sur l'application
				@endcomponent
			@else
				<div class="row">
					{{-- Des élèves existent sur l'application --}}

					<div class="col-12 mb-3 @empty($eleves) col-lg-6 @endempty">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}

							<div class="card-header gemah-bg-primary">Rechercher un élève</div>
							<div class="card-body">
								@component("web._includes.components.departement", ["optional" => true, "academies" => $academies, "id" => request("departement_id")])
								@endcomponent

								@component("web._includes.components.types_decisions", ["optional" => true, "types" => $typesEleve, "id" => request("type_eleve_id")])
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "nom", "placeholder" => "Ex: SMITH"])
									Nom
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "prenom", "placeholder" => "Ex: John"])
									Prénom
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "date_naissance", "type" => "date"])
									Date de naissance
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "code_ine", "placeholder" => "Ex: 0000000000X"])
									Code INE
								@endcomponent

								<div class="d-flex justify-content-between">
									<a class="btn btn-outline-dark" href="{{ route("web.scolarites.eleves.index") }}">Annuler la recherche</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($eleves)
						<div class="col-12 col-lg-6">
							{{-- Liste des derrniers élèves créés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestCreated as $eleve)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("eleves/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
													Voir le profil
												</a>
												@endHas
												@hasPermission("eleves/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
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
									@foreach($latestUpdated as $eleve)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
											<div class="btn-group">
												@hasPermission("eleves/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
													Voir le profil
												</a>
												@endHas
												@hasPermission("eleves/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
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
						{{-- Il s'agit d'une recherche d'élèves --}}

						<div class="col-12 mt-3">
							@component("web._includes.components.alert", ["type" => "success"])
								<b>Information(s) sur la recherche</b> <br>
								<ul class="mb-0">
									<li>
										Nombre d'élèves: {{ count($eleves) }}
									</li>
								</ul>
							@endcomponent
						</div>

						@if(count($eleves) > 0)
							<div class="col-12 mt-3">
								<div class="table-responsive">
									<table id="table" class="table table-stripped">
										<thead class="gemah-bg-primary">
											<tr class="align-middle">
												<th class="align-middle">Nom</th>
												<th class="align-middle">Prénom</th>
												<th class="align-middle">Date de naissance</th>
												<th class="align-middle" width="116px">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($eleves as $eleve)
												<tr>
													<td>{{ $eleve->nom }}</td>
													<td>{{ $eleve->prenom }}</td>
													<td data-order="{{ $eleve->date_naissance->timestamp }}">{{ $eleve->date_naissance->format("d/m/Y") }}</td>
													<td>
														<div class="btn-group">
															@hasPermission("eleves/show")
															<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">Voir le profil</a>
															@endHas
															@hasPermission("eleves/edit")
															<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
																Éditer
															</a>
															@endHas
														</div>
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
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection