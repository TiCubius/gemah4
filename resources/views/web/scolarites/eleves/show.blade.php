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
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.etablissements.index", [$eleve]) }}">Affecter un établissement</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.materiels.index", [$eleve]) }}">Affecter un matériel</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.affectations.responsables.index", [$eleve]) }}">Affecter à un responsable</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('web.scolarites.eleves.edit', [$eleve]) }}">Modifier l'élève</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.autorisations", [$eleve]) }}">Autorisation CNIL</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.consignes", [$eleve]) }}">Consignes du matériel</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.conventions", [$eleve]) }}">Convention</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.recapitulatifs", [$eleve]) }}">Récapitulatif</a>
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.impressions.recuperations", [$eleve]) }}">Récépissé de récupération</a>

					</div>
				</div>
			@endslot
		@endcomponent

		<div class="col-md-6 mb-3">
			<div class="card w-100">
				<div class="card-header gemah-bg-primary">Elève</div>

				<div class="card-body">
					<strong>Nom</strong>: {{ $eleve->nom }} <br>
					<strong>Prénom</strong>: {{ $eleve->prenom }} <br>
					<strong>Date de naissance</strong>: {{ $eleve->date_naissance }} <br>
					<strong>Joker</strong>: {{ $eleve->joker }} <br>
				</div>
			</div>
		</div>


		@isset($eleve->etablissement)
			<div class="col-md-6 mb-3">
				<div class="card w-100">
					<div class="card-header gemah-bg-primary d-flex align-items-center justify-content-between">Etablissement

						<button class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#modal-etablissements-{{ $eleve->etablissement->id }}">Désaffecter</button>
					</div>

					<div class="card-body">
						<strong>Nom</strong>: {{ $eleve->etablissement->nom }} <br>
						<strong>Type</strong>: {{ $eleve->etablissement->type }} <br>
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

						<button class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#modal-responsable-{{ $responsable->id }}">Désaffecter</button>
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
										<td>{{ $materiel->type->nom }}</td>
										<td>{{ $materiel->marque }}</td>
										<td>{{ $materiel->modele }}</td>
										<td>{{ Carbon\Carbon::parse($materiel->updated_at)->format('d/m/Y') }}</td>
										<td>
											<div class="btn-group">
												<a href="{{ route('web.materiels.stocks.show', [$materiel]) }}" class="btn btn-sm btn-outline-primary">Détail</a>
												<button class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#modal-materiel-{{ $materiel->id }}">Désaffecter</button>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="card-footer d-flex justify-content-between">
						<div>
							<strong>Prix global</strong> : {{ $eleve->prix_global }} €
						</div>

						<div>
							<strong>Prix actuel</strong> : {{ $eleve->materiels->sum('prix_ttc') }} €
						</div>
					</div>
				</div>
			</div>

		@elseif($eleve->prix_global > 0)

			<div class="card text-center mb-3">
				<div class="card-footer">
					<strong>Pas de matériel assignés</strong>
				</div>
				<div class="card-footer">
					<strong>Prix global</strong>: {{ $eleve->prix_global }} €
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
