@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Administration
		@endcomponent

		<div class="col-12 col-md-4">
			<div class="list-group mb-3">
				<div class="list-group-item flex-column align-items-start gemah-bg-primary">
					Départements, Académies et Régions
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
					Services et Utilisateurs
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
					Outils
				</div>

				<a href="{{ route("web.administrations.eleves.types.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types d'élèves
				</a>
				<a href="{{ route("web.administrations.etablissements.types.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des types d'établissements
				</a>

				<a href="{{ route("web.administrations.types.tickets.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des tickets
				</a>

				<a href="{{ route("web.administrations.materiels.etats.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
					Gestion des états matériel
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
