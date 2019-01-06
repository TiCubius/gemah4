@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.scolarites.eleves.create", "back" => "web.scolarites.index"])
			Gestion des élèves
		@endcomponent

		@if ($latestCreatedEleves->isEmpty())
			<div class="col-12 mb-3">
				<div class="alert alert-warning">
					Aucun élève n'est enregistré sur l'application
				</div>
			</div>
		@else
			<div class="col-12 mb-3">
				<form class="card" method="GET">
					<div class="card-header gemah-bg-primary">Rechercher un élève</div>
					<div class="card-body">
						<div class="form-group">
							<label class="optional" for="nom">Nom de l'élève</label>
							<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ app("request")->input("nom") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="prenom">Prénom de l'élève</label>
							<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ app("request")->input("prenom") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="date_naissance">Date de naissance</label>
							<input id="date_naissance" class="form-control" name="date_naissance" type="text" placeholder="Date de naissance" value="{{ app("request")->input("date_naissance") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="code_ine">Code INE</label>
							<input id="code_ine" class="form-control" name="code_ine" type="text" placeholder="Code INE" value="{{ app("request")->input("code_ine") }}">
						</div>

						<div class="d-flex justify-content-between">
							<a href="{{ route("web.scolarites.eleves.index") }}">
								<button class="btn btn-outline-dark" type="button">Annuler la recherche</button>
							</a>
							<button class="btn btn-outline-dark">Rechercher</button>
						</div>
					</div>
				</form>
			</div>

			@isset($searchedEleves)
				<div class="col-12 mb-3">
					@if($searchedEleves->isEmpty())
						<div class="alert alert-warning">
							Aucun élève n'a été trouvé avec ces critères
						</div>
					@else
						<table class="table table-sm table-hover text-center">
							<thead class="gemah-bg-primary">
								<tr>
									<th>Nom</th>
									<th>Email</th>
									<th>Téléphone</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($searchedEleves as $eleve)
									<tr>
										<th>{{ "{$eleve->nom} {$eleve->prenom}" }}</th>
										<td>{{ $eleve->email }}</td>
										<td>{{ $eleve->telephone }}</td>
										<td>
											<a href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
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
				@if($latestCreatedEleves->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers ajoutés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestCreatedEleves as $eleve)
									<li class="list-group-item d-flex justify-content-between">
										<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
										<a href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
											<button class="btn btn-sm btn-outline-primary">Editer</button>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if($latestUpdatedEleves->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers modifiés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestUpdatedEleves as $eleve)
									<li class="list-group-item d-flex justify-content-between ">
										<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
										<a href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
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