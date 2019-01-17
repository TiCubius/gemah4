@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Administration
		@endcomponent

		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-map-marker-alt"></i>  Départements, Académies et Régions
				</div>

				<a href="{{ route("web.administrations.departements.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des départements
				</a>
				<a href="{{ route("web.administrations.academies.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des académies
				</a>
				<a href="{{ route("web.administrations.regions.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des régions
				</a>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-users-cog"></i>  Services et Utilisateurs
				</div>

				<a href="{{ route("web.administrations.services.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des services
				</a>
				<a href="{{ route("web.administrations.utilisateurs.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des utilisateurs
				</a>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-tools"></i>  Outils
				</div>

				<a href="{{ route("web.administrations.eleves.types.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types d'élèves
				</a>
				<a href="{{ route("web.administrations.etablissements.types.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types d'établissement
				</a>

				<a href="{{ route("web.administrations.types.tickets.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types de ticket
				</a>

				<a href="{{ route("web.administrations.materiels.etats.administratifs.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des états administratifs matériel
				</a>

				<a href="{{ route("web.administrations.materiels.etats.physiques.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des états physiques matériel
				</a>

				<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					Historique des actions
				</a>
				<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					Liste des permissions
				</a>
			</div>
		</div>

	</div>
@endsection
