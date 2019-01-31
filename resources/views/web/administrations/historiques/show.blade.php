@extends('web._includes._master')
@section('content')
	<div class="row">
		@component("web._includes.components.title", ["back" => "web.administrations.historiques.index"])
			Détails de l'historique
		@endcomponent
		<div class="col-12">
			<div class="card mb-3">
				<div class="card-header gemah-bg-primary">
					{{ $historique->type }}
				</div>

				<div class="card-body">
					{{ $historique->information }}
				</div>

				<div class="card-footer d-flex justify-content-between">
					Le {{ \Carbon\Carbon::make($historique->created_at)->format("d/m/Y à h:i:s") }}
					<span class="text-muted">Par {{ $historique->user->nom ?? "utilisateur" }} {{ $historique->user->prenom ?? "supprimé"}}</span>
				</div>
			</div>

			@if($historique->region)
				@component("web._includes.components.card", ["route" => "web.administrations.regions.show", "id" => [$historique->region], "nom" => $historique->region->nom])
					Lien vers la région impliquée
				@endcomponent
			@endif

			@if($historique->academie)
				@component("web._includes.components.card", ["route" => "web.administrations.academies.edit", "id" => [$historique->academie], "nom" => $historique->academie->nom])
					Lien vers l'académie impliquée
				@endcomponent
			@endif

			@if($historique->departement)
				@component("web._includes.components.card", ["route" => "web.administrations.departements.edit", "id" => [$historique->departement], "nom" => $historique->departement->nom])
					Lien vers le département impliqué
				@endcomponent
			@endif

			@if($historique->responsable)
				@component("web._includes.components.card", ["route" => "web.responsables.edit", "id" => [$historique->responsable], "nom" => $historique->responsable->nom ." ". $historique->responsable->prenom])
					Lien vers le responsable impliqué
				@endcomponent
			@endif

			@if($historique->enseignant)
				@component("web._includes.components.card", ["route" => "web.scolarites.enseignants.edit", "id" => [$historique->enseignant], "nom" => $historique->enseignant->nom ." ". $historique->enseignant->prenom])
					Lien vers l'enseignant impliqué
				@endcomponent
			@endif

			@if($historique->etablissement)
				@component("web._includes.components.card", ["route" => "web.scolarites.etablissements.edit", "id" => [$historique->etablissement], "nom" => $historique->etablissement->nom])
					Lien vers l'établissement impliqué
				@endcomponent
			@endif

			@if($historique->typeEtablissement)
				@component("web._includes.components.card", ["route" => "web.administrations.types.etablissements.edit", "id" => [$historique->typeEtablissement], "nom" => $historique->typeEtablissement->libelle])
					Lien vers le type d'établissement impliqué
				@endcomponent
			@endif

			@if($historique->eleve)
				@component("web._includes.components.card", ["route" => "web.scolarites.eleves.show", "id" => [$historique->eleve], "nom" => $historique->eleve->nom ." ". $historique->eleve->prenom])
					Lien vers l'élève impliqué
				@endcomponent

				@if($historique->ticket)
					@component("web._includes.components.card", ["route" => "web.scolarites.eleves.tickets.show", "id" => [$historique->eleve, $historique->tic], "nom" => $historique->ticket->libelle])
						Lien vers le ticket impliqué
					@endcomponent
				@endif

				@if($historique->document)
					@component("web._includes.components.card", ["route" => "web.scolarites.eleves.documents.edit", "id" =>  [$historique->eleve, $historique->doc], "nom" => $historique->document->nom])
						Lien vers le document impliqué
					@endcomponent
				@endif
			@endif

			@if($historique->typeEleve)
				@component("web._includes.components.card", ["route" => "web.administrations.types.eleves.edit", "id" => [$historique->typeEleve], "nom" => $historique->typeEleve->libelle])
					Lien vers le type d'élève impliqué
				@endcomponent
			@endif

			@if($historique->typeTicket)
				@component("web._includes.components.card", ["route" => "web.administrations.types.tickets.edit", "id" => [$historique->typeTicket], "nom" => $historique->typeTicket->libelle])
					Lien vers le type de ticket impliqué
				@endcomponent
			@endif

			@if($historique->typeDocument)
				@component("web._includes.components.card", ["route" => "web.administrations.types.documents.edit", "id" => [$historique->typeDocument], "nom" => $historique->typeDocument->libelle])
					Lien vers le type de document impliqué
				@endcomponent
			@endif

			@if($historique->domaineMateriel)
				@component("web._includes.components.card", ["route" => "web.materiels.domaines.edit", "id" => [$historique->domaineMateriel], "nom" => $historique->domaineMateriel->libelle])
					Lien vers le domaine de matériel impliqué
				@endcomponent
			@endif

			@if($historique->etatAdministratifMateriel)
				@component("web._includes.components.card", ["route" => "web.administrations.materiels.etats.administratifs.edit", 	"id" => [$historique->etatAdministratifMateri ], "nom" => $historique->etatAdministratifMateriel->libelle])
					Lien vers l'état administratif de matériel impliqué
				@endcomponent
			@endif

			@if($historique->etatPhysiqueMateriel)
				@component("web._includes.components.card", ["route" => "web.administrations.materiels.etats.physiques.edit", "id" => [$historique->etatPhysiqueMateriel], "nom" => $historique->etatPhysiqueMateriel->libelle])
					Lien vers l'état physique de matériel impliqué
				@endcomponent
			@endif

			@if($historique->materiel)
				@component("web._includes.components.card", ["route" => "web.materiels.stocks.show", "id" => [$historique->materiel], "nom" => $historique->materiel->modele])
					Lien vers le matériel impliqué
				@endcomponent
			@endif

			@if($historique->typeMateriel)
				@component("web._includes.components.card", ["route" => "web.materiels.types.edit", "id" => [$historique->typeMateriel], "nom" => $historique->typeMateriel->libelle])
					Lien vers le type de matériel impliqué
				@endcomponent
			@endif

			@if($historique->service)
				@component("web._includes.components.card", ["route" => "web.administrations.services.edit", "id" => [$historique->service], "nom" => $historique->service->nom])
					Lien vers le service impliqué
				@endcomponent
			@endif

			@if($historique->utilisateur)
				@component("web._includes.components.card", ["route" => "web.administrations.utilisateurs.edit", "id" => [$historique->utilisateur], "nom" => $historique->utilisateur->nom ." ". $historique->utilisateur->prenom])
					Lien vers l'utilisateur impliqué
				@endcomponent
			@endif
		</div>
	</div>
@endsection