@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.scolarites.enseignants.create", "back" => "web.scolarites.index"])
			Gestion des enseignants
		@endcomponent

		@if ($latestCreatedEnseignants->isEmpty())
			<div class="col-12 mb-3">
				<div class="alert alert-warning">
					Aucun enseignant n'est enregistré sur l'application
				</div>
			</div>
		@else
			<div class="col-12 mb-3">
				<form class="card" method="GET">
					<div class="card-header gemah-bg-primary">Rechercher un enseignant</div>
					<div class="card-body">
						<div class="form-group">
							<label class="optional" for="nom">Nom du enseignant</label>
							<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ app("request")->input("nom") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="prenom">Prénom du enseignant</label>
							<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ app("request")->input("prenom") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="email">Adresse E-Mail</label>
							<input id="email" class="form-control" name="email" type="text" placeholder="E-Mail" value="{{ app("request")->input("email") }}">
						</div>

						<div class="form-group">
							<label class="optional" for="telephone">N° de Téléphone</label>
							<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Téléphonne" value="{{ app("request")->input("telephone") }}">
						</div>

						<div class="d-flex justify-content-between">
							<a href="{{ route("web.scolarites.enseignants.index") }}">
								<button class="btn btn-outline-dark" type="button">Annuler la recherche</button>
							</a>
							<button class="btn btn-outline-dark">Rechercher</button>
						</div>
					</div>
				</form>
			</div>

			@isset($searchedEnseignants)
				<div class="col-12 mb-3">
					@if($searchedEnseignants->isEmpty())
						<div class="alert alert-warning">
							Aucun enseignant n'a été trouvé avec ces critères
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
								@foreach($searchedEnseignants as $enseignant)
									<tr>
										<th>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</th>
										<td>{{ $enseignant->email }}</td>
										<td>{{ $enseignant->telephone }}</td>
										<td>
											<a href="{{ route("web.scolarites.enseignants.edit", [$enseignant->id]) }}">
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
				@if($latestCreatedEnseignants->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers ajoutés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestCreatedEnseignants as $enseignant)
									<li class="list-group-item d-flex justify-content-between">
										<span>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</span>
										<a href="{{ route("web.scolarites.enseignants.edit", [$enseignant->id]) }}">
											<button class="btn btn-sm btn-outline-primary">Editer</button>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if($latestUpdatedEnseignants->isNotEmpty())
					<div class="col-12 col-lg-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary text-white">Derniers modifiés</div>
							<ul class="list-group list-group-flush">
								@foreach($latestUpdatedEnseignants as $enseignant)
									<li class="list-group-item d-flex justify-content-between ">
										<span>{{ "{$enseignant->nom} {$enseignant->prenom}" }}</span>
										<a href="{{ route("web.scolarites.enseignants.edit", [$enseignant->id]) }}">
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
