@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.show", "id" => [$eleve]])
			Affectation d'un matériel
		@endcomponent

		<div class="col-12">
			<form class="card mb-3">
				<div class="card-header gemah-bg-primary">Rechercher un matériel</div>

				<div class="card-body">
					@component("web._includes.components.departement", ["academies" => $academies, "optional" => true])
					@endcomponent

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
									<option selected value="{{ $etat->id }}">{{ $etat->nom }}</option>
								@else
									<option value="{{ $etat->id }}">{{ $etat->nom }}</option>
								@endif
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label class="optional" for="marque">Marque</label>
						<input id="marque" class="form-control" name="marque" type="text" placeholder="Ex: Asus" value="{{ Request::get("marque") }}">
					</div>

					<div class="form-group">
						<label class="optional" for="modele">Modèle</label>
						<input id="modele" class="form-control" name="modele" type="text" placeholder="Ex: ProBook 650 G3" value="{{ Request::get("modele") }}">
					</div>

					<div class="form-group">
						<label class="optional" for="numero_serie">N° de Série</label>
						<input id="numero_serie" class="form-control" name="numero_serie" type="text" placeholder="Ex: 754W-8574-1456" value="{{ Request::get("numero_serie") }}">
					</div>

					<div class="d-flex justify-content-between">
						<a href="{{ route("web.scolarites.eleves.affectations.materiels.index", [$eleve->id]) }}">
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
						Aucun matériel non lié à l'élève {{ $eleve->prenom }} {{ $eleve->nom }} n'a été trouvé avec ces critères
					@endcomponent
				</div>
			@else
				<div class="col-12 mb-3">
					<div class="card">
						<div class="card-body">
							Nombres de matériel : {{ count($searchedMateriels) }}
							<ul class="mb-0">
								@foreach($searchedMateriels->groupBy("etat_materiel_id") as $materiels)
									<li>{{ count($materiels) }} {{ $materiels[0]->etat->libelle }}</li>
								@endforeach
								<li>
									{{ count($searchedMateriels->where("eleve_id", "!=", null)) }} Affectés
								</li>
								<li>
									{{ count($searchedMateriels->where("eleve_id", null)) }} Non affectés
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-12 table-responsive">
					<table class="table table-hover text-center">
						<thead class="gemah-bg-primary">
							<tr class="text-center">
								<th class="align-middle">État</th>
								<th class="align-middle">Type</th>
								<th class="align-middle">Marque</th>
								<th class="align-middle">Modèle</th>
								<th class="align-middle">N° de Série</th>
								<th class="align-middle">Prix</th>
								<th class="align-middle">Assigné à</th>
								<th class="align-middle">Date de prêt</th>
								<th class="align-middle">Actions</th>
							</tr>
						</thead>

						<tbody>
							@foreach($searchedMateriels as $materiel)
								<tr>
									<td class="couleur" data-toggle="tooltip" data-placement="bottom" title="{{ $materiel->etat->libelle }}" style="width: 57px; background:{{ $materiel->etat->couleur }}"></td>
									<td>{{ $materiel->type->libelle }}</td>
									<td>{{ $materiel->marque }}</td>
									<td>{{ $materiel->modele }}</td>
									<td>{{ $materiel->numero_serie }}</td>
									<td>{{ $materiel->prix }}</td>
									@if ($materiel->eleve)
										<td>
											<a href="{{ route("web.scolarites.eleves.show", [$materiel->eleve]) }}">
												{{ "{$materiel->eleve->nom} {$materiel->eleve->prenom}" }}
											</a>
										</td>
										<td>{{ \Carbon\Carbon::parse($materiel->date_pret)->format("d/m/Y") }}</td>
									@else
										<td></td>
										<td></td>
									@endif
									<td>
										<form action="{{ route("web.scolarites.eleves.affectations.materiels.attach", [$eleve, $materiel]) }}" method="POST">
											{{ csrf_field() }}
											<button type="submit" class="btn btn-sm btn-outline-primary">Affecter</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		@endif
	</div>

@endsection

@include("web._includes.sidebars.eleve")