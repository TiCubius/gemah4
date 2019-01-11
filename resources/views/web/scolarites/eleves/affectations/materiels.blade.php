@extends("web._includes._master")
@section("content")

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.materiels", "id" => [$eleve]])
			Affectation d'un matériel
		@endcomponent

		<div class="col-12">
			<form class="card mb-3">
				<div class="card-header gemah-bg-primary">Rechercher un matériel</div>
				<div class="card-body">
					<div class="form-group">
						<label class="optional" for="type_id">Type</label>
						<select id="type_id" class="form-control" name="type_id">
							<option value>Sélectionnez un type</option>
							@foreach ($domaines as $domaine)
								<optgroup label="{{ $domaine->nom }}">
									@foreach($domaine->types as $type)
										@if(Request::get("type_id") == $type->id)
											<option selected value="{{ $type->id }}">{{ $type->nom }}</option>
										@else
											<option value="{{ $type->id }}">{{ $type->nom }}</option>
										@endif
									@endforeach
								</optgroup>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label class="optional" for="etat_id">État</label>
						<select id="etat_id" class="form-control" name="etat_id">
							<option value>Sélectionnez un état</option>
							@foreach($etats as $etat)
								@if(Request::get("etat_id") == $etat->id)
									<option selected value="{{ $etat->id }}">{{ $etat->nom }}</option>
								@else
									<option value="{{ $etat->id }}">{{ $etat->nom }}</option>
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
						<label class="optional" for="num_serie">N° de Série</label>
						<input id="num_serie" class="form-control" name="num_serie" type="text" placeholder="E.g : 754W-8574-1456" value="{{ Request::get("num_serie") }}">
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
								{{ debug($materiel) }}
								<tr>
									<td class="couleur" style="width: 57px; background:{{ $materiel->etat->couleur }}"></td>
									<td>{{ $materiel->marque }}</td>
									<td>{{ $materiel->modele }}</td>
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