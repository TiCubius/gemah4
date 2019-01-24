@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.scolarites.etablissements.create", "back" => "web.scolarites.index"])
			Gestion des établissements
		@endcomponent


		<div class="col-12 mb-3">
			@if($latestCreated->isEmpty())
				{{-- Aucun établissement n'est présent dans la BDD --}}

				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun établissement n'est enregistré sur l'application
				@endcomponent
			@else
				<div class="row">
					{{-- Des établissements existent sur l'application --}}

					<div class="col-12 @empty($etablissements) col-lg-6 @endempty">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}

							<div class="card-header gemah-bg-primary">Rechercher un établissement</div>
							<div class="card-body">
								@component("web._includes.components.departement", ["optional" => true, "academies" => $academies, "id" => request("departement_id")])
								@endcomponent

								@component("web._includes.components.types_etablissements", ["optional" => true, "types" => $types, "id" => request("type_etablissement_id")])
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "nom", "placeholder" => "Ex: SMITH"])
									Nom
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "ville", "placeholder" => "Ex: John"])
									Ville
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "telephone", "placeholder" => "Ex: 01 23 45 67 89"])
									Téléphone
								@endcomponent

								<div class="d-flex justify-content-between">
									<a class="btn btn-outline-dark" href="{{ route("web.scolarites.etablissements.index") }}">Annuler la recherche</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($etablissements)
						<div class="col-6">
							{{-- Liste des derrniers établissements créés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestCreated as $etablissement)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$etablissement->nom}" }}</span>
											<div class="btn-group">
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.etablissements.edit", [$etablissement]) }}">Editer</a>
											</div>
										</li>
									@endforeach
								</ul>
							</div>


							{{-- Liste des derrniers établissements modifiés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers modifiés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestUpdated as $etablissement)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$etablissement->nom}" }}</span>
											<div class="btn-group">
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.etablissements.edit", [$etablissement]) }}">Editer</a>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					@else
						{{-- Il s'agit d'une recherche d'établissements --}}

						<div class="col-12 mt-3">
							@component("web._includes.components.alert", ["type" => "success"])
								<b>Information(s) sur la recherche</b> <br>
								<ul class="mb-0">
									<li>
										Nombre d'établissements: {{ count($etablissements) }}
									</li>
								</ul>
							@endcomponent
						</div>

						@if(count($etablissements) > 0)
							<div class="col-12 mt-3">
								<div class="table-responsive">
									<table id="table" class="table table-stripped">
										<thead class="gemah-bg-primary">
											<tr class="align-middle">
												<th class="align-middle">Nom</th>
												<th class="align-middle">Ville</th>
												<th class="align-middle">Telephone</th>
												<th class="align-middle" width="116px">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($etablissements as $etablissement)
												<tr>
													<td>{{ $etablissement->nom }}</td>
													<td>{{ $etablissement->ville }}</td>
													<td>{{ $etablissement->telephone }}</td>
													<td>
														<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.etablissements.edit", [$etablissement]) }}">Editer</a>
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
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection