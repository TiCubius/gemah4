@extends("web._includes._master")

@section("content")

	<div class="row">
		@component("web._includes.components.title", ["add" => "web.scolarites.eleves.create", "back" => "web.scolarites.index"])
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

					<div class="col-12 col-lg-6">
						<form class="card" method="GET">
							{{-- Formulaire de recherche --}}
							<div class="card-header">Rechercher un élève</div>
							<div class="card-body">
								@component("web._includes.components.departement",["academies" => $academies, "id" => app("request")->input("departement_id"), "optional" => true])
								@endcomponent

								@component("web._includes.components.types_eleves",["types" => $typesEleve, "id" => app("request")->input("type_eleve_id")])
								@endcomponent

								<div class="form-group">
									<label class="optional" for="nom">Nom de l'élève</label>
									<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: SMITH" value="{{ app("request")->input("nom") }}">
								</div>

								<div class="form-group">
									<label class="optional" for="prenom">Prénom de l'élève</label>
									<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ app("request")->input("prenom") }}">
								</div>

								<div class="form-group">
									<label class="optional" for="date_naissance">Date de naissance</label>
									<input id="date_naissance" class="form-control" name="date_naissance" type="text" placeholder="Ex: 01/01/2019" value="{{ app("request")->input("date_naissance") }}">
								</div>

								<div class="form-group">
									<label class="optional" for="code_ine">Code INE</label>
									<input id="code_ine" class="form-control" name="code_ine" type="text" placeholder="Ex : 0000000000X" value="{{ app("request")->input("code_ine") }}">
								</div>

								<div class="d-flex justify-content-between">
									<a class="btn btn-outline-dark" href="{{ route("web.scolarites.eleves.index") }}">Annuler la recherche</a>
									<button class="btn btn-outline-dark">Rechercher</button>
								</div>
							</div>
						</form>
					</div>

					@empty($eleves)
						<div class="row col-12 col-lg-6">
							<div class="col-12 mb-3">
								<div class="card">
									{{-- Liste des derrniers élèves créés --}}
									<div class="card-header">Derniers ajoutés</div>
									<ul class="list-group list-group-flush">
										@foreach($latestCreated as $eleve)
											<li class="list-group-item d-flex justify-content-between">
												<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
												<div class="btn-group">
													<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
														Voir le profil
													</a>
													<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
														Editer
													</a>
												</div>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
							<div class="col-12">
								<div class="card">
									{{-- Liste des derrniers élèves modifiés --}}
									<div class="card-header">Derniers modifiés</div>
									<ul class="list-group list-group-flush">
										@foreach($latestUpdated as $eleve)
											<li class="list-group-item d-flex justify-content-between">
												<span>{{ "{$eleve->nom} {$eleve->prenom}" }}</span>
												<div class="btn-group">
													<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
														Voir le profil
													</a>
													<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.edit", [$eleve]) }}">
														Editer
													</a>
												</div>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					@endunless


					@isset($eleves)
						{{-- Il s'agit d'une recherche d'élève --}}
					@endisset
				</div>
			@endif

		</div>
	</div>

@endsection