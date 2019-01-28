<?php

namespace App\Providers;

use App\Models\Academie;
use App\Models\Decision;
use App\Models\Departement;
use App\Models\Document;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\EtatAdministratifMateriel;
use App\Models\EtatPhysiqueMateriel;
use App\Models\Materiel;
use App\Models\Region;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TypeDocument;
use App\Models\TypeEleve;
use App\Models\TypeEtablissement;
use App\Models\TypeMateriel;
use App\Models\TypeTicket;
use App\Models\Utilisateur;
use App\Observers\AcademieObserver;
use App\Observers\DecisionObserver;
use App\Observers\DepartementObserver;
use App\Observers\DocumentObserver;
use App\Observers\DomaineMaterielObserver;
use App\Observers\EleveObserver;
use App\Observers\EtablissementObserver;
use App\Observers\EtatAdministratifMaterielObserver;
use App\Observers\EtatPhysiqueMaterielObserver;
use App\Observers\MaterielObserver;
use App\Observers\RegionObserver;
use App\Observers\ResponsableObserver;
use App\Observers\ServiceObserver;
use App\Observers\TicketMessageObserver;
use App\Observers\TicketObserver;
use App\Observers\TypeDocumentObserver;
use App\Observers\TypeEleveObserver;
use App\Observers\TypeEtablissementObserver;
use App\Observers\TypeMaterielObserver;
use App\Observers\TypeTicketObserver;
use App\Observers\UtilisateurObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        /** Historique **/
        Region::observe(RegionObserver::class);
        Academie::observe(AcademieObserver::class);
        Departement::observe(DepartementObserver::class);

        Responsable::observe(ResponsableObserver::class);
        Enseignant::observe(EnseignantObserver::class);
        Etablissement::observe(EtablissementObserver::class);
        TypeEtablissement::observe(TypeEtablissementObserver::class);
        Eleve::observe(EleveObserver::class);
        TypeEleve::observe(TypeEleveObserver::class);

        Ticket::observe(TicketObserver::class);
        TicketMessage::observe(TicketMessageObserver::class);
        TypeTicket::observe(TypeTicketObserver::class);

        Document::observe(DocumentObserver::class);
        TypeDocument::observe(TypeDocumentObserver::class);

        DomaineMateriel::observe(DomaineMaterielObserver::class);
        EtatAdministratifMateriel::observe(EtatAdministratifMaterielObserver::class);
        EtatPhysiqueMateriel::observe(EtatPhysiqueMaterielObserver::class);
        Materiel::observe(MaterielObserver::class);
        TypeMateriel::observe(TypeMaterielObserver::class);

        Service::observe(ServiceObserver::class);
        Utilisateur::observe(UtilisateurObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
