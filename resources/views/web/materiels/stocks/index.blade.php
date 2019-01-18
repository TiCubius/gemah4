@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.materiels.stocks.create", "back" => "web.materiels.index"])
			Gestion des stocks matériel
		@endcomponent

		@if(isset($latestCreatedMateriels) && $latestCreatedMateriels->isEmpty())
			<div class="col-12">
				@component("web._includes.components.alert", ["type" => "warning"])
					Aucun matériel n'est enregistré sur l'application
				@endcomponent
			</div>

		@else
			<div class="col-12">
				<form class="card mb-3">
					<div class="card-header gemah-bg-primary">Rechercher un matériel</div>
					<div class="card-body">
						<div class="form-group">
							<label class="optional" for="type_materiel_id">Type</label>
							<select id="type_materiel_id" class="form-control" name="type_materiel_id">
								<option value>Sélectionnez un type</option>
								@foreach ($domaines as $domaine)
									<optgroup label="{{ $domaine->libelle }}">
										@foreach($domaine->types as $type)
											@if(Request::get("type_materiel_id") == $type->id)
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
							<label class="optional" for="etat_materiel_id">État</label>
							<select id="etat_materiel_id" class="form-control" name="etat_materiel_id">
								<option value>Sélectionnez un état</option>
								@foreach($etats as $etat)
									@if(Request::get("etat_materiel_id") == $etat->id)
										<option selected value="{{ $etat->id }}">{{ $etat->libelle }}</option>
									@else
										<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
									@endif
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label class="optional" for="marque">Marque</label>
							<input id="marque" class="form-control" name="marque" type="text" placeholder="E.g : Asus" value="{{ Request::get("marque") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="modele">Modèle</label>
							<input id="modele" class="form-control" name="modele" type="text" placeholder="E.g : ProBook 650 G3" value="{{ Request::get("modele") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="numero_serie">N° de Série</label>
							<input id="numero_serie" class="form-control" name="numero_serie" type="text" placeholder="E.g : 754W-8574-1456" value="{{ Request::get("numero_serie") }}">
						</div>

						<div class="d-flex justify-content-between">
							<a href="{{ route("web.materiels.stocks.index") }}">
								<button class="btn btn-outline-dark" type="button">Annuler la recherche</button>
							</a>
							<button class="btn btn-outline-dark">Rechercher</button>
						</div>
					</div>
				</form>

			</div>
			@isset($searchedMateriels)
				@if($searchedMateriels->isEmpty())
					<div class="col-12">
						@component("web._includes.components.alert", ["type" => "warning"])
							Aucun matériel n'a été trouvé avec ces critères
						@endcomponent
					</div>

				@else
					<div class="col-12">
						<table class="table table-hover text-center">
							<thead class="gemah-bg-primary">
								<tr>
									<td>État</td>
									<th>Marque</th>
									<th>Modèle</th>
									<th>Actions</th>
								</tr>
							</thead>

							<tbody>
								@foreach($searchedMateriels as $materiel)
									<tr>
										<td class="couleur" style="width: 57px; background:{{ $materiel->etat->couleur }}"></td>
										<td>{{ $materiel->marque }}</td>
										<td>{{ $materiel->modele }}</td>
										<td>
											<a href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Afficher</button>
											</a>
											<a href="{{ route("web.materiels.stocks.edit", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Editer</button>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif

			@else
				@if($latestCreatedMateriels->isNotEmpty())
					<div class="col-12 col-lg-6">
						<div class="card mb-3">
							<div class="card-header gemah-bg-primary">Derniers ajoutés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestCreatedMateriels as $materiel)
									<li class="list-group-item d-flex justify-content-between">
										<div class="couleur" style="width: 31px; background:{{ $materiel->etat->couleur }}"></div>

										<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
										<div class="actions">
											<a href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Afficher</button>
											</a>
											<a href="{{ route("web.materiels.stocks.edit", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Editer</button>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if($latestUpdatedMateriels->isNotEmpty())
					<div class="col-12 col-lg-6">
						<div class="card mb-3">
							<div class="card-header gemah-bg-primary">Derniers modifiés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestUpdatedMateriels as $materiel)
									<li class="list-group-item d-flex justify-content-between">
										<div class="couleur" style="width: 31px; background:{{ $materiel->etat->couleur }}"></div>

										<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
										<div class="actions">
											<a href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Afficher</button>
											</a>
											<a href="{{ route("web.materiels.stocks.edit", [$materiel]) }}">
												<button class="btn btn-sm btn-outline-primary">Editer</button>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
			@endif
		@endif
	</div>

@endsection