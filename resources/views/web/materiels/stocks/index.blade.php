@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.materiels.stocks.create", "back" => "web.materiels.index"])
			Gestion des Stocks Matériel
		@endcomponent

		@if($latestCreatedMateriels->isEmpty())
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
							<label class="optional" for="type_id">Type</label>
							<select id="type_id" class="form-control" name="type_id">
								<option value="">Sélectionnez un type</option>
								@foreach ($domaines as $domaine)
									<optgroup label="{{ $domaine->nom }}">
										@foreach($domaine->types as $type)
											<option value="{{ $type->id }}">{{ $type->nom }}</option>
										@endforeach
									</optgroup>
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
							<label class="optional" for="num_serie">N° de Série</label>
							<input id="num_serie" class="form-control" name="num_serie" type="text" placeholder="E.g : 754W-8574-1456" value="{{ Request::get("num_serie") }}">
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
									<th>Marque</th>
									<th>Modèle</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($searchedMateriels as $materiel)
									<tr>
										<td>{{ $materiel->marque }}</td>
										<td>{{ $materiel->modele }}</td>
										<td>
											<a href="{{ route("web.materiels.stocks.edit", [$materiel->id]) }}">
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
							<div class="card-header gemah-bg-primary">Derniers créés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestCreatedMateriels as $materiel)
									<li class="list-group-item d-flex justify-content-between">
										<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
										<a href="{{ route("web.materiels.stocks.edit", [$materiel->id]) }}">
											<button class="btn btn-sm btn-outline-primary">Editer</button>
										</a>
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
										<span>{{ "{$materiel->marque} {$materiel->modele}" }}</span>
										<a href="{{ route("web.materiels.stocks.edit", [$materiel->id]) }}">
											<button class="btn btn-sm btn-outline-primary">Editer</button>
										</a>
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