<?php

namespace Tests\Feature\Administrations;

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
use App\Models\Historique;
use App\Models\Materiel;
use App\Models\Region;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TypeDocument;
use App\Models\TypeEtablissement;
use App\Models\TypeMateriel;
use App\Models\TypeTicket;
use App\Models\Utilisateur;
use Tests\TestCase;

class HistoriquesTest extends TestCase
{
    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexHistoriques()
    {
        Historique::create([
            "from_id" => $this->user->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);
        $request = $this->get("/administrations/historiques");

        $request->assertStatus(200);
        $request->assertSee("Historique");
        $request->assertSee("Type");
        $request->assertSee("Contenue");
        $request->assertSee("Date");
        $request->assertSee("Action");

        $request->assertSee("unit.testing");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriques()
    {
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertStatus(200);
        $request->assertSee("Détails de l'historique");
        $request->assertSee($historique->type);
        $request->assertSee($historique->information);
        $request->assertSee("Par {$this->user->nom} {$this->user->prenom}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecEleve()
    {
        $eleve = factory(Eleve::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "eleve_id" => $eleve->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'élève impliqué");
        $request->assertSee("Accéder à {$eleve->nom} {$eleve->prenom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecTicket()
    {
        $ticket = factory(Ticket::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "eleve_id" => $ticket->eleve->id,
            "ticket_id" => $ticket->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'élève impliqué");
        $request->assertSee("Accéder à {$ticket->eleve->nom} {$ticket->eleve->prenom}");


        $request->assertSee("Lien vers le ticket impliqué");
        $request->assertSee("Accéder à {$ticket->libelle}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecDocument()
    {
        $document = factory(Document::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "eleve_id" => $document->eleve->id,
            "document_id" => $document->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'élève impliqué");
        $request->assertSee("Accéder à {$document->eleve->nom} {$document->eleve->prenom}");

        $request->assertSee("Lien vers le document impliqué");
        $request->assertSee("Accéder à {$document->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecRegion()
    {
        $region = factory(Region::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "region_id" => $region->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers la région impliquée");
        $request->assertSee("Accéder à {$region->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecAcademie()
    {
        $academie = factory(Academie::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "academie_id" => $academie->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'académie impliquée");
        $request->assertSee("Accéder à {$academie->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecDepartement()
    {
        $departement = factory(Departement::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "departement_id" => $departement->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le département impliqué");
        $request->assertSee("Accéder à {$departement->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecResponsable()
    {
        $responsable = factory(Responsable::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "responsable_id" => $responsable->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le responsable impliqué");
        $request->assertSee("Accéder à {$responsable->nom} {$responsable->prenom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecEnseignant()
    {
        $enseignant = factory(Enseignant::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "enseignant_id" => $enseignant->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'enseignant impliqué");
        $request->assertSee("Accéder à {$enseignant->nom} {$enseignant->prenom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecEtablissement()
    {
        $etablissement = factory(Etablissement::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "etablissement_id" => $etablissement->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'établissement impliqué");
        $request->assertSee("Accéder à {$etablissement->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecTypeEtablissement()
    {
        $typeEtablissement = factory(TypeEtablissement::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type_etablissement_id" => $typeEtablissement->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le type d'établissement impliqué");
        $request->assertSee("Accéder à {$typeEtablissement->nom}");
    }


    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecTypeTicket()
    {
        $typeTicket = factory(TypeTicket::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type_ticket_id" => $typeTicket->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le type de ticket impliqué");
        $request->assertSee("Accéder à {$typeTicket->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecTypeDocument()
    {
        $typeDocument = factory(TypeDocument::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type_document_id" => $typeDocument->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le type de document impliqué");
        $request->assertSee("Accéder à {$typeDocument->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecDomaineMateriel()
    {
        $domaineMateriel = factory(DomaineMateriel::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "domaine_id" => $domaineMateriel->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le domaine de matériel impliqué");
        $request->assertSee("Accéder à {$domaineMateriel->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecEtatAdministratifMateriel()
    {
        $etatAdministratifMateriel = factory(EtatAdministratifMateriel::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "etat_administratif_materiel_id" => $etatAdministratifMateriel->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'état administratif de matériel impliqué");
        $request->assertSee("Accéder à {$etatAdministratifMateriel->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecEtatPhysiqueMateriel()
    {
        $etatPhysiqueMateriel = factory(EtatPhysiqueMateriel::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "etat_physique_materiel_id" => $etatPhysiqueMateriel->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'état physique de matériel impliqué");
        $request->assertSee("Accéder à {$etatPhysiqueMateriel->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecMateriel()
    {
        $materiel = factory(Materiel::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "materiel_id" => $materiel->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le matériel impliqué");
        $request->assertSee("Accéder à {$materiel->modele}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecTypeMateriel()
    {
        $typeMateriel = factory(TypeMateriel::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type_materiel_id" => $typeMateriel->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le type de matériel impliqué");
        $request->assertSee("Accéder à {$typeMateriel->libelle}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecService()
    {
        $service = factory(Service::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "service_id" => $service->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers le service impliqué");
        $request->assertSee("Accéder à {$service->nom}");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriquesAvecUtilisateur()
    {
        $utilisateur = factory(Utilisateur::class)->create();
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "utilisateur_id" => $utilisateur->id,
            "type" => "unit.testing",
            "information" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertSee("Lien vers l'utilisateur impliqué");
        $request->assertSee("Accéder à {$utilisateur->nom} {$utilisateur->prenom}");
    }
}