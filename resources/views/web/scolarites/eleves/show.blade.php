@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Profil élève de {{ $eleve->nom }} {{ $eleve->prenom }}
		@endcomponent

		<div class="col-md-6 mb-3">
			<div class="card w-100">
				<div class="card-header gemah-bg-primary">
					Elève
				</div>

				<div class="card-body">
					<p class="mb-0">
						<strong>Nom</strong>: {{ $eleve->nom }}
					</p>

					<p class="mb-0">
						<strong>Prénom</strong>: {{ $eleve->prenom }}
					</p>

					<p class="mb-0">
						<strong>Date de naissance</strong>: {{ $eleve->date_naissance }}
					</p>

					<p class="mb-0">
						<strong>Joker</strong>: {{ $eleve->joker }}
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-6 mb-3">
			<div class="card w-100">
				<div class="card-header gemah-bg-primary">
					Etablissement
				</div>

				<div class="card-body">
					<p class="mb-0">
						<strong>Nom</strong>: {{ $eleve->etablissement->nom }}
					</p>

					<p class="mb-0">
						<strong>Type</strong>: {{ $eleve->etablissement->type }}
					</p>

					<p class="mb-0">
						<strong>Classe</strong>: {{ $eleve->classe }}
					</p>

					<p class="mb-0">
						<strong>Adresse</strong>: {{ $eleve->etablissement->adresse }}
					</p>
				</div>
			</div>
		</div>

		@foreach($eleve->responsables as $responsable)
			<div class="col-md-6">
				<div class="card w-100">
					<div class="card-header gemah-bg-primary">
						Responsable
					</div>

					<div class="card-body">
						<p class="mb-0">
							<strong>Nom</strong>: {{ $responsable->nom }}
						</p>

						<p class="mb-0">
							<strong>Prénom</strong>: {{ $responsable->prenom }}
						</p>

						<p class="mb-0">
							<strong>Adresse</strong>: {{ $responsable->adresse }}
						</p>

						<p class="mb-0">
							<strong>Ville</strong>: {{ $responsable->ville }}
						</p>

						<p class="mb-0">
							<strong>Téléphone</strong>: {{ $responsable->telephone }}
						</p>

						<p class="mb-0">
							<strong>Email</strong>: {{ $responsable->email }}
						</p>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	@if(count($eleve->materiels) >= 1)
		<div class="row">
			<div class="col-md-12 mt-3">
				<div class="card">
					<div class="card-header gemah-bg-primary">
						Informations sur le matériel
					</div>
					<table class="table table-hover mb-0">
						<thead class="table-striped">
							<tr>
								<th scope="col"> Type du matériel</th>
								<th scope="col"> Marque du matériel</th>
								<th scope="col" width="100px"> Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($eleve->materiels as $materiel)
								<tr>
									<td>{{ $materiel->type->nom }}</td>
									<td>{{ $materiel->marque }}</td>
									<td>
										<a href="{{ route('web.materiels.stocks.show', $materiel) }}" target="_blank" class="btn btn-sm btn-outline-primary">
											Détail
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="card-footer">
						<strong>Prix global</strong>: {{ $eleve->prix_global }} €
						<div class="float-right">
							<strong>Prix actuel </strong>: {{ $eleve->materiels->sum('prix_ttc') }} €
						</div>
					</div>
				</div>
			</div>
		</div>
	@elseif($eleve->prix_global > 0)
		<div class="card text-center">
			<div class="card-footer">
				<strong>Pas de matériel assignés</strong>
			</div>
			<div class="card-footer">
				<strong>Prix global</strong>: {{ $eleve->prix_global }} €
			</div>
		</div>
	@endif
@endsection

@section("sidebar")
	<div class="row">
		<a href="{{ route('web.scolarites.eleves.show', ['id' => $eleve->id]) }}" class="btn btn-outline-primary col-12 mb-1">Récapitulatif</a>
		<a href="#" class="btn btn-outline-primary col-12 mb-1">Document</a>
		<a href="#" class="btn btn-outline-primary col-12 mb-1">Matériel</a>
		<a href="#" class="btn btn-outline-primary col-12 mb-1">Maintenance</a>
	</div>
@endsection