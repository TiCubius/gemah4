<?php

namespace Tests\Feature\Administrations;

use App\Models\Academie;
use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Etablissement;
use App\Models\Materiel;
use App\Models\Responsable;
use App\Models\Service;
use Tests\TestCase;

class DepartementsTest extends TestCase
{
    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexDepartements()
    {
        $departements = factory(Departement::class, 5)->create();

        $request = $this->get("/administrations/departements");

        $request->assertStatus(200);
        $request->assertSee("Gestion des départements");

        foreach ($departements as $departement) {
            $request->assertSee($departement->nom);
            $request->assertSee($departement->academie->nom);
        }
    }


    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */
    public function testAffichageFormulaireCreationDepartement()
    {
        $request = $this->get("/administrations/departements/create");

        $request->assertStatus(200);
        $request->assertSee("Création d'un département");
        $request->assertSee("Nom");
        $request->assertSee("Académie");
        $request->assertSee("Créer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationDepartementIncomplet()
    {
        $request = $this->post("/administrations/departements", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
     * d'un département déjà existant
     */
    public function testTraitementFormulaireCreationDepartementExistant()
    {
        $academie = factory(Academie::class)->create();
        $departements = factory(Departement::class, 5)->create();

        $request = $this->post("/administrations/departements", [
            "_token" => csrf_token(),
            "id" => $departements->random()->id,
            "nom" => $departements->random()->nom,
            "academie" => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et qu'un département à bien été créée lors de la soumissions d'un
     * formulaire de création complet
     */
    public function testTraitementFormulaireCreationDepartementComplet()
    {
        $academie = factory(Academie::class)->create();

        $request = $this->post("/administrations/departements", [
            "_token" => csrf_token(),
            "id" => "unit.testing",
            "nom" => "unit.testing",
            "academie" => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id" => "unit.testing",
            "nom" => "unit.testing",
        ]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/created",
            "contenue" => "Le département unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie que les données présentes sur le profil sont bien celles attendues
     */
    public function testAffichageProfilDepartement()
    {
        $departement = factory(Departement::class)->create();
        $services = factory(Service::class, 2)->create([
            "departement_id" => $departement->id
        ]);
        $eleves = factory(Eleve::class, 2)->create([
            "departement_id" => $departement->id
        ]);
        $responsables = factory(Responsable::class, 2)->create([
            "departement_id" => $departement->id
        ]);
        $etablissements = factory(Etablissement::class, 2)->create([
            "departement_id" => $departement->id
        ]);
        $materiels = factory(Materiel::class, 2)->create([
            "departement_id" => $departement->id
        ]);

        $request = $this->get("/administrations/departements/{$departement->id}");

        $request->assertStatus(200);
        $request->assertSee("Profil du département \"{$departement->nom}\"");

        $request->assertSee("Services");
        $request->assertSee("Action");
        foreach ($services as $service) {
            $request->assertSee($service->nom);
            $request->assertSee("Détails");
        }

        $request->assertSee("Eleves");
        $request->assertSee("Action");
        foreach ($eleves as $eleve) {
            $request->assertSee($eleve->nom);
            $request->assertSee($eleve->prenom);
            $request->assertSee("Détails");
        }

        $request->assertSee("Responsables");
        $request->assertSee("Action");
        foreach ($responsables as $responsable) {
            $request->assertSee($responsable->nom);
            $request->assertSee($responsable->prenom);
            $request->assertSee("Détails");
        }

        $request->assertSee("Etablissements");
        $request->assertSee("Action");
        foreach ($etablissements as $etablissement) {
            $request->assertSee($etablissement->nom);
            $request->assertSee("Détails");
        }

        $request->assertSee("Materiels");
        $request->assertSee("Action");
        foreach ($materiels as $materiel) {
            $request->assertSee($materiel->modele);
            $request->assertSee("Détails");
        }
    }

    /**
     * Vérifie que le formulaire d'édition contient bien les champs nécessaires
     */
    public function testAffichageFormulaireEditionDepartement()
    {
        $academie = factory(Academie::class)->create();
        $departement = factory(Departement::class)->create();

        $request = $this->get("/administrations/departements/{$departement->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Édition de {$departement->nom}");
        $request->assertSee("Nom");
        $request->assertSee("Éditer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
     */
    public function testTraitementFormulaireEditionDepartementIncomplet()
    {
        $academie = factory(Academie::class)->create();
        $departement = factory(Departement::class)->create();

        $request = $this->put("/administrations/departements/{$departement->id}", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
     * d'un département déjà existant
     */
    public function testTraitementFormulaireEditionDepartementExistant()
    {
        $academie = factory(Academie::class)->create();
        $departements = factory(Departement::class, 2)->create();

        $request = $this->put("/administrations/departements/{$departements[0]->id}", [
            "_token" => csrf_token(),
            "id" => $departements[1]->id,
            "nom" => $departements[1]->nom,
            "academie" => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("departements", [
            "id" => $departements[0]->id,
            "nom" => $departements[0]->nom,
        ]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/modified",
            "contenue" => "Le département {$departements[1]->nom} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que le département à bien été édité lors de la soumission
     * d'un formulaire d'édition complet sans modification
     */
    public function testTraitementFormulaireEditionDepartementCompletSansModification()
    {
        $academie = factory(Academie::class)->create();
        $departement = factory(Departement::class)->create([
            "academie_id" => $academie->id,
        ]);

        $request = $this->put("/administrations/departements/{$departement->id}", [
            "_token" => csrf_token(),
            "id" => $departement->id,
            "nom" => $departement->nom,
            "academie" => $departement->academie_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id" => $departement->id,
            "nom" => $departement->nom,
        ]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/modified",
            "contenue" => "Le département {$departement->nom} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que le département à bien été édité lors de la soumission
     * d'un formulaire d'édition complet avec modification
     */
    public function testTraitementFormulaireEditionDepartementCompletAvecModification()
    {
        $academie = factory(Academie::class)->create();
        $departement = factory(Departement::class)->create();

        $request = $this->put("/administrations/departements/{$departement->id}", [
            "_token" => csrf_token(),
            "id" => "unit.testing",
            "nom" => "unit.testing",
            "academie" => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id" => "unit.testing",
            "nom" => "unit.testing",
        ]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/modified",
            "contenue" => "Le département unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionDepartement()
    {
        $departement = factory(Departement::class)->create();

        $request = $this->get("/administrations/departements/{$departement->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . $departement->nom . "</b>.");
    }

    /**
     * Vérifie que des erreurs sont présentes et que le service n'est pas supprimé s'il est associé à des académies
     */
    public function testTraitementSuppressionDepartementAssocie()
    {
        $departement = factory(Departement::class)->create();
        $service = factory(Service::class)->create([
            "departement_id" => $departement->id,
        ]);

        $request = $this->delete("/administrations/departements/{$departement->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("departements", ["nom" => $departement->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/deleted",
            "contenue" => "Le département {$departement->nom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que le service à bien été supprimé s'il n'est associé à aucun
     * service
     */
    public function testTraitementSuppressionDepartementNonAssocie()
    {
        $departement = factory(Departement::class)->create();

        $request = $this->delete("/administrations/departements/{$departement->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("departements", ["nom" => $departement->nom]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "departement/deleted",
            "contenue" => "Le département {$departement->nom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }
}

?>