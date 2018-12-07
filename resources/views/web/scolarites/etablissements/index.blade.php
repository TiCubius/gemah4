@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.scolarites.etablissements.create", "back" => "web.scolarites.index"])
			Gestion des établissements
		@endcomponent

		@if ($latestCreatedEtablissements->isEmpty())
			<div class="col-12 mb-3">
				<div class="alert alert-warning">
					Aucun établissement n'est enregistré sur l'application
				</div>
			</div>
		@else
			<div class="col-12 mb-3">
				<form class="card" method="GET">
					<div class="card-header gemah-bg-primary">Rechercher un établissement</div>
					<div class="card-body">
						<div class="form-group">
							<label class="optional" for="nom">Nom de l'établissement</label>
							<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ app("request")->input("nom") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="ville">Ville</label>
							<input id="ville" class="form-control" name="ville" type="text" placeholder="Ville" value="{{ app("request")->input("ville") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="telephone">N° de Téléphone</label>
							<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Téléphonne" value="{{ app("request")->input("telephone") }}">
						</div>

						<div class="d-flex justify-content-between">
							<a href="{{ route("web.scolarites.etablissements.index") }}">
								<button class="btn btn-outline-dark" type="button">Annuler la recherche</button>
							</a>
							<button class="btn btn-outline-dark">Rechercher</button>
						</div>
					</div>
				</form>
			</div>

			@isset($searchedEtablissements)
				<div class="col-12 mb-3">
					@if($searchedEtablissements->isEmpty())
						<div class="alert alert-warning">
							Aucun établissement n'a été trouvé avec ces critères
						</div>
					@else
						<table class="table table-sm table-hover text-center">
							<thead class="gemah-bg-primary">
								<tr>
									<th>Nom</th>
									<th>Ville</th>
									<th>Téléphone</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($searchedEtablissements as $etablissement)
									<tr>
										<th>{{ "{$etablissement->nom} {$etablissement->prenom}" }}</th>
										<td>{{ $etablissement->ville }}</td>
										<td>{{ $etablissement->telephone }}</td>
										<td>
											<a href="{{ route("web.scolarites.etablissements.edit", [$etablissement->id]) }}">
												<button class="btn btn-sm btn-outline-primary">Editer</button>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@endif
				</div>
			@else
				@if($latestCreatedEtablissements->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers ajoutés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestCreatedEtablissements as $etablissement)
									<li class="list-group-item d-flex justify-content-between">
										<span>{{ "{$etablissement->nom} {$etablissement->prenom}" }}</span>
										<a href="{{ route("web.scolarites.etablissements.edit", [$etablissement->id]) }}">
											<button class="btn btn-sm btn-outline-primary">Editer</button>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if($latestUpdatedEtablissements->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers modifiés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestUpdatedEtablissements as $etablissement)
									<li class="list-group-item d-flex justify-content-between ">
										<span>{{ "{$etablissement->nom} {$etablissement->prenom}" }}</span>
										<a href="{{ route("web.scolarites.etablissements.edit", [$etablissement->id]) }}">
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
