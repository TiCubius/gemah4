@extends('web._includes._master')
@php($title = "Administration")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Administration
		@endcomponent

		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-map-marker-alt"></i> Départements, Académies et Régions
				</div>

				@hasPermission("administrations/departements/index")
				<a href="{{ route("web.administrations.departements.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des départements
				</a>
				@endHas
				@hasPermission("administrations/academies/index")
				<a href="{{ route("web.administrations.academies.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des académies
				</a>
				@endHas
				@hasPermission("administrations/regions/index")
				<a href="{{ route("web.administrations.regions.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des régions
				</a>
				@endHas
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-users-cog"></i> Services et Utilisateurs
				</div>

				@hasPermission("administrations/services/index")
				<a href="{{ route("web.administrations.services.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des services
				</a>
				@endHas
				@hasPermission("administrations/utilisateurs/index")
				<a href="{{ route("web.administrations.utilisateurs.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des utilisateurs
				</a>
				@endHas
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					<i class="fas fa-tools"></i> Outils
				</div>

				@hasPermission("administrations/etats/materiels/administratifs/index")
				<a href="{{ route("web.administrations.materiels.etats.administratifs.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des états administratifs matériel
				</a>
				@endHas

				@hasPermission("administrations/etats/materiels/physiques/index")
				<a href="{{ route("web.administrations.materiels.etats.physiques.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des états physiques matériel
				</a>
				@endHas

				@hasPermission("administrations/parametres/edit")
				<a href="{{ route("web.administrations.parametres.edit") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Personnalisation des conventions
				</a>
				@endHas

				@hasPermission("administrations/types/etablissements/index")
				<a href="{{ route("web.administrations.types.etablissements.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types d'établissement
				</a>
				@endHas

				@hasPermission("administrations/types/decisions/index")
				<a href="{{ route("web.administrations.types.decisions.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types de décision
				</a>
				@endHas

				@hasPermission("administrations/types/documents/index")
				<a href="{{ route("web.administrations.types.documents.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types de document
				</a>
				@endHas

				@hasPermission("administrations/types/tickets/index")
				<a href="{{ route("web.administrations.types.tickets.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types de ticket
				</a>
				@endHas

				@hasPermission("administrations/historiques/index")
				<a href="{{ route("web.administrations.historiques.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Historique des actions
				</a>
				@endHas
			</div>
		</div>

	</div>
@endsection
