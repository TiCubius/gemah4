@extends("web._includes._master")@php($title = "Gestion des stocks matériel")

@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.materiels.stocks.create", "permission" => "materiels/stocks/create", "back" => "web.materiels.index"])
			Gestion des stocks matériel
		@endcomponent


		<div class="col-12 mb-3">
			@if($latestCreated->isEmpty())
				{{-- Aucun matériel n'est présent dans la BDD --}}

				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun matériel n'est enregistré sur l'application
				@endcomponent
			@else
				<div class="row">
					{{-- Des matériels existent sur l'application --}}

					<div class="col-12 mb-3 @empty($materiels) col-lg-6 @endempty">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}

							<div class="card-header gemah-bg-primary">Rechercher du matériel</div>
							<div class="card-body">
								@component("web._includes.components.departement",["academies" => $academies, "id" => app("request")->input("departement_id"), "optional" => true])
								@endcomponent

								<div class="form-group">
									<label class="optional" for="type_materiel_id">Type</label>

									<select id="type_materiel_id" class="form-control" name="type_materiel_id">
										<option value>Sélectionnez un type</option>
										@foreach ($domaines as $domaine)
											<optgroup label="{{ $domaine->libelle }}">
												@foreach($domaine->types as $type)
													@if(request("type_materiel_id") == $type->id)
														<option selected value="{{ $type->id }}">{{ $type->libelle }}</option>
													@else
														<option value="{{ $type->id }}">{{ $type->libelle }}</option>
													@endif
												@endforeach
											</optgroup>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label class="optional" for="etat_administratif_materiel_id">Etat
										administratif</label>
									<select id="etat_administratif_materiel_id" class="form-control" name="etat_administratif_materiel_id">
										<option value>Sélectionnez un état</option>
										@foreach($etatsAdministratifs as $etat)
											@if(request("etat_administratif_materiel_id") == $etat->id)
												<option selected value="{{ $etat->id }}">{{ $etat->libelle }}</option>
											@else
												<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
											@endif
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label class="optional" for="etat_physique_materiel_id">Etat physique</label>
									<select id="etat_physique_materiel_id" class="form-control" name="etat_physique_materiel_id">
										<option value>Sélectionnez un état</option>
										@foreach($etatsPhysiques as $etat)
											@if(request("etat_physique_materiel_id") == $etat->id)
												<option selected value="{{ $etat->id }}">{{ $etat->libelle }}</option>
											@else
												<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
											@endif
										@endforeach
									</select>
								</div>

								@component("web._includes.components.input", ["optional" => true, "name" => "marque", "placeholder" => "Ex: HP"])
									Marque
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "modele", "placeholder" => "Ex: ProBook 650 G3"])
									Modèle
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "numero_serie", "placeholder" => "Ex: XXXX-XXXX-XXXX-XXXX"])
									Numéro de série
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "cle_produit", "placeholder" => "Ex: XXXX-XXXX-XXXX-XXXX"])
									Clé de produit
								@endcomponent

								@component("web._includes.components.input", ["optional" => true, "name" => "achat_pour", "placeholder" => "Ex: SMITH John"])
									Acheté pour
								@endcomponent

								<div class="d-flex justify-content-between">
									<a class="btn btn-outline-dark" href="{{ route("web.materiels.stocks.index") }}">
										Annuler la recherche
									</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($materiels)
						<div class="col-12 col-lg-6">
							{{-- Liste des derrniers matériels créés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestCreated as $materiel)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
											<div class="btn-group">
												@hasPermission("materiels/stocks/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
													<i class="fas fa-info-circle"></i>
													Détails
												</a> @endHas

												@hasPermission("materiels/stocks/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.edit", [$materiel]) }}">
													Éditer </a> @endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>


							{{-- Liste des derrniers matériels modifiés --}}

							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Derniers modifiés</div>
								<ul class="list-group list-group-flush">
									@foreach($latestUpdated as $materiel)
										<li class="list-group-item d-flex justify-content-between">
											<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
											<div class="btn-group">
												@hasPermission("materiels/stocks/show")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
													<i class="fas fa-info-circle"></i>
													Détails
												</a> @endHas

												@hasPermission("materiels/stocks/edit")
												<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.edit", [$materiel]) }}">
													Éditer </a> @endHas
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					@else
						{{-- Il s'agit d'une recherche de matériels --}}

						<div class="col-12 mt-3">
							@component("web._includes.components.alert", ["type" => "success"])
								<b>Information(s) sur la recherche</b> <br>
								<ul class="mb-0">
									<li>
										Nombre de matériels: {{ count($materiels) }}
									</li>
									@foreach($materiels->groupBy("etat_materiel_id") as $materiel)
										<li>{{ count($materiel) }} {{ $materiel[0]->etatAdministratif->libelle }}</li>
									@endforeach
									<li>
										{{ count($materiels->where("eleve_id", "!=", null)) }} Affectés
									</li>
									<li>
										{{ count($materiels->where("eleve_id", null)) }} Non affectés
									</li>
								</ul>
							@endcomponent
						</div>

						@if(count($materiels) > 0)
							<div class="col-12 mt-3">
								<div class="table-responsive">
									<table id="table" class="table table-stripped">
										<thead class="gemah-bg-primary">
											<tr class="align-middle">
												<th class="align-middle">Etat</th>
												<th class="align-middle">Type</th>
												<th class="align-middle">Marque</th>
												<th class="align-middle">Modèle</th>
												<th class="align-middle">Numéro de série</th>
												<th class="align-middle">Prix TTC</th>
												<th class="align-middle">Acheté pour</th>
												<th class="align-middle">Affecté à</th>
												<th class="align-middle">Date de prêt</th>
												<th class="align-middle">Etat physique</th>
												<th class="align-middle" width="116px">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach($materiels as $materiel)
												<tr>
													<td class="couleur" data-toggle="tooltip" data-placement="bottom" title="{{ $materiel->etatAdministratif->libelle }}" style="width: 57px; background:{{ $materiel->etatAdministratif->couleur }}"></td>
													<td>{{ $materiel->type->libelle }}</td>
													<td>{{ $materiel->marque }}</td>
													<td>{{ $materiel->modele }}</td>
													<td>{{ $materiel->numero_serie }}</td>
													<td>{{ $materiel->prix_ttc }}</td>
													<td>{{ $materiel->achat_pour }}</td>
													@isset($materiel->eleve)
														<td>
															@hasPermission("eleves/show")
															<a href="{{ route("web.scolarites.eleves.show", [$materiel->eleve]) }}">{{ "{$materiel->eleve->nom} {$materiel->eleve->prenom}" }}</a>
															@endHas
														</td>

													@else
														<td></td>
													@endisset
													<td>{{ $materiel->date_pret ? $materiel->date_pret->format("d/m/Y") : null }}</td>
													<td>{{ $materiel->etatPhysique->libelle }}</td>
													<td>
														@hasPermission("materiels/stocks/show")
														<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
															<i class="fas fa-info-circle"></i>
															Détails
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
					{"orderable": false, "targets": 10},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection