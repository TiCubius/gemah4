@extends('web._includes._master')
@section('content')

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Profil élève de {{ $eleve->nom }} {{ $eleve->prenom }}

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion élève
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("affectations/etablissements/index")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.etablissements.index", [$eleve]) }}">Affecter un établissement</a>
						@endHas
						@hasPermission("affectations/materiels/index")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.materiels.index", [$eleve]) }}">Affecter un matériel</a>
						@endHas
						@hasPermission("affectations/responsables/index")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.responsables.index", [$eleve]) }}">Affecter à un responsable</a>
						@endHas

						@hasPermission("eleves/edit")
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('web.scolarites.eleves.edit', [$eleve]) }}">Éditer l'élève</a>
						@endHas

						<div class="dropdown-divider"></div>
						@hasPermission("eleves/impressions/autorisations")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.autorisations", [$eleve]) }}" target="_blank">Autorisation CNIL</a>
						@endHas
						@hasPermission("eleves/impressions/consignes")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.consignes", [$eleve]) }}" target="_blank">Consignes du matériel</a>
						@endHas
						@hasPermission("eleves/impressions/conventions")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.conventions", [$eleve]) }}" target="_blank">Convention</a>
						@endHas
						@hasPermission("eleves/impressions/recapitulatifs")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.recapitulatifs", [$eleve]) }}" target="_blank">Récapitulatif</a>
						@endHas
						@hasPermission("eleves/impressions/recuperations")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.recuperations", [$eleve]) }}" target="_blank">Récépissé de récupération</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent

		<div class="col-md-6 mb-3">
			<div class="card w-100">
				<div class="card-header gemah-bg-primary d-flex justify-content-between align-items-center">
					Elève

					<div>
						@foreach($eleve->types as $type)
							<div class="badge badge-success m-0">{{ $type->libelle }}</div>
						@endforeach
					</div>
				</div>

				<div class="card-body">
					<strong>Nom</strong>: {{ $eleve->nom }} <br>
					<strong>Prénom</strong>: {{ $eleve->prenom }} <br>
					<strong>Date de naissance</strong>: {{ $eleve->date_naissance->format("d/m/Y") }} <br>
					<strong>Joker</strong>: {{ $eleve->joker }} <br>
				</div>
			</div>
		</div>


		@isset($eleve->etablissement)
			<div class="col-md-6 mb-3">
				<div class="card w-100">
					<div class="card-header gemah-bg-primary d-flex align-items-center justify-content-between">
						Etablissement

						<div class="btn btn-outline-light btn-sm dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Gestion établissement
						</div>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
							@hasPermission("responsables/show")
							<a class="dropdown-item" href="{{ route("web.scolarites.etablissements.show", [$eleve->etablissement]) }}" target="_blank">Détails de l'établissement</a>
							@endHas
							@hasPermission("responsables/edit")
							<a class="dropdown-item" href="{{ route("web.scolarites.etablissements.edit", [$eleve->etablissement]) }}" target="_blank">Éditer l'établissement</a>
							@endHas

							<div class="dropdown-divider"></div>
							@hasPermission("affectations/responsables/detach")
							<div class="dropdown-item">
								<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-etablissements-{{ $eleve->etablissement->id }}">Désaffecter l'établissement</button>
							</div>
							@endHas
						</div>
					</div>

					<div class="card-body">
						<strong>Nom</strong>: {{ $eleve->etablissement->nom }} <br>
						<strong>Type</strong>: {{ $eleve->etablissement->type->libelle }} <br>
						<strong>Classe</strong>: {{ $eleve->classe }} <br>
						<strong>Adresse</strong>: {{ $eleve->etablissement->adresse }} <br>
						<strong>Ville</strong>: {{ $eleve->etablissement->ville }} <br>
						<strong>Téléphone</strong>: {{ $eleve->etablissement->telephone }} <br>
					</div>
				</div>
			</div>
		@endisset

		@foreach($eleve->responsables as $responsable)
			<div class="col-md-6 mb-3">
				<div class="card w-100">
					<div class="card-header gemah-bg-primary d-flex align-items-center justify-content-between">
						Responsable

						<div class="btn btn-outline-light btn-sm dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Gestion responasble
						</div>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
							@hasPermission("responsables/show")
							<a class="dropdown-item" href="{{ route("web.responsables.show", [$responsable]) }}" target="_blank">
								Détails du responsable
							</a>
							@endHas
							@hasPermission("responsables/edit")
							<a class="dropdown-item" href="{{ route("web.responsables.edit", [$responsable]) }}" target="_blank">
								Éditer le responsable
							</a>
							@endHas

							<div class="dropdown-divider"></div>
							@hasPermission("affectations/responsables/detach")
							<div class="dropdown-item">
								<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-responsable-{{ $responsable->id }}">Désaffecter le responsable</button>
							</div>
							@endHas
						</div>
					</div>

					<div class="card-body">
						<strong>Nom</strong>: {{ $responsable->nom }} <br>
						<strong>Prénom</strong>: {{ $responsable->prenom }} <br>
						<strong>Adresse</strong>: {{ $responsable->adresse }} <br>
						<strong>Ville</strong>: {{ $responsable->ville }} <br>
						<strong>Téléphone</strong>: {{ $responsable->telephone }} <br>
						<strong>Email</strong>: {{ $responsable->email }} <br>
					</div>
				</div>
			</div>
		@endforeach

		@if(count($eleve->materiels) >= 1)

			<div class="col-md-12 mb-3">
				<div class="card">
					<div class="card-header gemah-bg-primary">Informations sur le matériel</div>

					<div class="table-responsive">
						<table class="table table-hover mb-0">
							<thead>
								<tr>
									<th>Type</th>
									<th>Marque</th>
									<th>Modèle</th>
									<th>Prêt le</th>
									<th class="text-center" style="width: 185px;">Actions</th>
								</tr>
							</thead>

							<tbody>
								@foreach($eleve->materiels as $materiel)
									<tr>
										<td>{{ $materiel->type->libelle }}</td>
										<td>{{ $materiel->marque }}</td>
										<td>{{ $materiel->modele }}</td>
										<td>{{ Carbon\Carbon::parse($materiel->updated_at)->format('d/m/Y') }}</td>
										<td>
											<div class="btn-group">
												@hasPermission("materiels/stocks/show")
												<a href="{{ route('web.materiels.stocks.show', [$materiel]) }}" class="btn btn-sm btn-outline-primary">Détail</a>
												@endHas
												@hasPermission("affectations/materiels/detach")
												<button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modal-materiel-{{ $materiel->id }}">Désaffecter
												</button>
												@endHas
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="card-footer d-flex justify-content-between">
						<div data-toggle="tooltip" data-placement="bottom" title="Le prix global correspond au prix de tout les matériels qui ont été affectés et désaffectés de cet élève">
							<strong>Prix global</strong> : {{ $eleve->prix_global }} €
						</div>

						<div>
							<strong>Prix actuel</strong> : {{ $eleve->materiels->sum('prix_ttc') }} €
						</div>
					</div>
				</div>
			</div>
		@elseif($eleve->prix_global > 0)
			<div class="col-12">
				<div class="card text-center mb-3">
					<div class="card-footer">
						<strong>Aucun matériel assigné</strong>
					</div>

					<div class="card-footer" data-toggle="tooltip" data-placement="bottom" title="Le prix global correspond au prix de tout les matériels qui ont été affectés et désaffectés de cet élève">
						<strong>Prix global</strong>: {{ $eleve->prix_global }} €
					</div>
				</div>
			</div>
		@endif

	</div>

	@isset($eleve->etablissement)
		@component("web._includes.components.modals.detach", ["route" => route("web.scolarites.eleves.affectations.etablissements.detach", [$eleve, $eleve->etablissement]), "id" => "modal-etablissements-{$eleve->etablissement->id}"])
			@slot("name")
				{{ "{$eleve->etablissement->nom}" }}
			@endslot
		@endcomponent
	@endisset

	@foreach($eleve->materiels as $materiel)
		@component("web._includes.components.modals.detach", ["route" => route("web.scolarites.eleves.affectations.materiels.detach", [$eleve, $materiel]), "id" => "modal-materiel-{$materiel->id}"])
			@slot("name")
				{{ "{$materiel->marque} {$materiel->modele}" }}
			@endslot
		@endcomponent
	@endforeach

	@foreach($eleve->responsables as $responsable)
		@component("web._includes.components.modals.detach", ["route" => route("web.scolarites.eleves.affectations.responsables.detach", [$eleve, $responsable]), "id" => "modal-responsable-{$responsable->id}"])
			@slot("name")
				{{ "{$responsable->nom} {$responsable->prenom}" }}
			@endslot
		@endcomponent
	@endforeach

@endsection

@include("web._includes.sidebars.eleve")