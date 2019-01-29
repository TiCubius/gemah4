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
                    {{ $historique->contenue }}
                </div>

                <div class="card-footer">
                    Créé le {{ \Carbon\Carbon::make($historique->created_at)->format("h:i:s d/m/Y") }}
                    <span class="text-muted">Effectué par {{ $historique->user->nom }} {{ $historique->user->prenom }}</span>
                </div>
            </div>

                @if($historique->region)
                    @component("web._includes.components.card", [
                        "title" => "Lien vers la région impliquée",
                        "route" => "web.administrations.regions.show",
                        "id" => [$historique->region]])
                    @endcomponent
                @endif

                @if($historique->academie)
                    @component("web._includes.components.card", [
                        "title" => "Lien vers l'académie impliquée",
                        "route" => "web.administrations.academies.edit",
                        "id" => [$historique->academie]])
                    @endcomponent
                @endif

                @if($historique->departement)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le département impliqué",
                    "route" => "web.administrations.departements.edit",
                    "id" => [$historique->departement]])
                    @endcomponent
                @endif

                @if($historique->responsable)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le responsable impliqué",
                    "route" => "web.responsables.edit",
                    "id" => [$historique->responsable]])
                    @endcomponent
                @endif

                @if($historique->enseignant)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'enseignant impliqué",
                    "route" => "web.scolarites.enseignants.edit",
                    "id" => [$historique->enseignant]])
                    @endcomponent
                @endif

                @if($historique->etablissement)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'établissement impliqué",
                    "route" => "web.scolarites.etablissements.edit",
                    "id" => [$historique->etablissement]])
                    @endcomponent
                @endif

                @if($historique->typeEtablissement)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le type d'établissement impliqué",
                    "route" => "web.administrations.types.etablissements",
                    "id" => [$historique->typeEtablissement]])
                    @endcomponent
                @endif

                @if($historique->eleve)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'élève impliqué",
                    "route" => "web.scolarites.eleves.show",
                    "id" => [$historique->eleve]])
                    @endcomponent

                    @if($historique->ticket)
                        @component("web._includes.components.card", [
                        "title" => "Lien vers le ticket impliqué",
                        "route" => "web.scolarites.eleves.tickets.show",
                        "id" => [$historique->eleve, $historique->ticket]])
                        @endcomponent
                    @endif

                    @if($historique->document)
                        @component("web._includes.components.card", [
                        "title" => "Lien vers le document impliqué",
                        "route" => "web.scolarites.eleves.documents.edit",
                        "id" => [$historique->eleve, $historique->document]])
                        @endcomponent
                    @endif
                @endif

                @if($historique->typeEleve)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le type d'élève impliqué",
                    "route" => "web.administrations.types.eleves.edit",
                    "id" => [$historique->typeEleve]])
                    @endcomponent
                @endif

                @if($historique->typeTicket)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le type de ticket impliqué",
                    "route" => "web.administrations.types.tickets.edit",
                    "id" => [$historique->typeTicket]])
                    @endcomponent
                @endif

                @if($historique->typeDocument)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le type de document impliqué",
                    "route" => "web.administrations.types.documents.edit",
                    "id" => [$historique->typeDocument]])
                    @endcomponent
                @endif

                @if($historique->domaineMateriel)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le domaine de matériel impliqué",
                    "route" => "web.materiels.domaines.edit",
                    "id" => [$historique->domaineMateriel]])
                    @endcomponent
                @endif

                @if($historique->etatAdministratifMateriel)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'état administratif de matériel impliqué",
                    "route" => "web.administrations.materiels.etats.administratifs.edit",
                    "id" => [$historique->etatAdministratifMateriel]])
                    @endcomponent
                @endif

                @if($historique->etatPhysiqueMateriel)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'état physique de matériel impliqué",
                    "route" => "web.administrations.materiels.etats.physiques.edit",
                    "id" => [$historique->etatPhysiqueMateriel]])
                    @endcomponent
                @endif

                @if($historique->materiel)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le matériel impliqué",
                    "route" => "web.materiels.stocks.show",
                    "id" => [$historique->materiel]])
                    @endcomponent
                @endif

                @if($historique->typeMateriel)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le type de matériel impliqué",
                    "route" => "web.materiels.types.edit",
                    "id" => [$historique->typeMateriel]])
                    @endcomponent
                @endif

                @if($historique->service)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers le service impliqué",
                    "route" => "web.administrations.services.edit",
                    "id" => [$historique->service]])
                    @endcomponent
                @endif

                @if($historique->utilisateur)
                    @component("web._includes.components.card", [
                    "title" => "Lien vers l'utilisateur impliqué",
                    "route" => "web.administrations.utilisateurs.edit",
                    "id" => [$historique->utilisateur]])
                    @endcomponent
                @endif
            </div>
        </div>
    </div>
@endsection