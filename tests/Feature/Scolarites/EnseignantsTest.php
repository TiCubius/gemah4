<?php

namespace Tests\Feature\Scolarites;

use App\Models\Departement;
use App\Models\Enseignant;
use Tests\TestCase;

class EnseignantsTest extends TestCase
{

    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexEnseignants()
    {
        $enseignants = factory(Enseignant::class, 5)->create();

        $request = $this->get("/scolarites/enseignants");

        $request->assertStatus(200);
        $request->assertSee("Gestion des enseignants");

        foreach ($enseignants as $enseignant) {
            $request->assertSee($enseignant->nom);
            $request->assertSee($enseignant->prenom);
        }
    }


    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */
    public function testAffichageFormulaireCreationEnseignant()
    {
        $request = $this->get("/scolarites/enseignants/create");

        $request->assertStatus(200);
        $request->assertSee("Création d'un enseignant");
        $request->assertSee("Département");
        $request->assertSee("Nom");
        $request->assertSee("Prénom");
        $request->assertSee("Adresse E-Mail");
        $request->assertSee("Téléphone");
        $request->assertSee("Créer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationEnseignantIncomplet()
    {
        $request = $this->post("/scolarites/enseignants", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
     * d'un Enseignant déjà existante
     */
    public function testTraitementFormulaireCreationEnseignantExistant()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->post("/scolarites/enseignants", [
            "_token" => csrf_token(),
            "civilite" => "Mme",
            "nom" => $enseignant->nom,
            "prenom" => $enseignant->prenom,
            "email" => $enseignant->email,
            "telephone" => $enseignant->telephone,
            "departement_id" => $enseignant->departement_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et qu'un Enseignant à bien été créée lors de la soumissions d'un
     * formulaire de création complet
     */
    public function testTraitementFormulaireCreationEnseignantComplet()
    {
        $departement = factory(Departement::class)->create();
        $request = $this->post("/scolarites/enseignants", [
            "_token" => csrf_token(),
            "civilite" => "Mme",
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "email" => "unit@testing.fr",
            "telephone" => "0123456789",
            "departement_id" => $departement->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("enseignants", ["email" => "unit@testing.fr"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "enseignant/created",
            "contenue" => "L'enseignant unit.testing unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }


    /**
     * Vérifie que le formulaire d'édition contient bien les champs nécessaires
     */
    public function testAffichageFormulaireEditionEnseignant()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->get("/scolarites/enseignants/{$enseignant->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Édition de {$enseignant->nom}");
        $request->assertSee("Département");
        $request->assertSee("Nom");
        $request->assertSee("Prénom");
        $request->assertSee("Adresse E-Mail");
        $request->assertSee("Téléphone");
        $request->assertSee("Éditer");
        $request->assertSee("Supprimer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
     */
    public function testTraitementFormulaireEditionEnseignantIncomplet()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->put("/scolarites/enseignants/{$enseignant->id}", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
     * d'un Enseignant déjà existante
     */
    public function testTraitementFormulaireEditionEnseignantExistant()
    {
        $enseignants = factory(Enseignant::class, 2)->create();

        $request = $this->put("/scolarites/enseignants/{$enseignants[0]->id}", [
            "_token" => csrf_token(),
            "civilite" => $enseignants[1]->civilite,
            "nom" => $enseignants[1]->nom,
            "prenom" => $enseignants[1]->prenom,
            "email" => $enseignants[1]->email,
            "telephone" => $enseignants[1]->telephone,
            "departement_id" => $enseignants[1]->departement_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("enseignants", [
            "nom" => $enseignants[0]->nom,
            "prenom" => $enseignants[0]->prenom,
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été édité lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionEnseignantCompletSansModification()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->put("/scolarites/enseignants/{$enseignant->id}", [
            "_token" => csrf_token(),
            "civilite" => $enseignant->civilite,
            "nom" => $enseignant->nom,
            "prenom" => $enseignant->prenom,
            "email" => $enseignant->email,
            "telephone" => $enseignant->telephone,
            "departement_id" => $enseignant->departement_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("enseignants", [
            "nom" => $enseignant->nom,
            "prenom" => $enseignant->prenom,
        ]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "enseignant/deleted",
            "contenue" => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été édité lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionEnseignantCompletAvecModification()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->put("/scolarites/enseignants/{$enseignant->id}", [
            "_token" => csrf_token(),
            "civilite" => "M.",
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "email" => "unit@testing.fr",
            "telephone" => "0123456789",
            "departement_id" => $enseignant->departement_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("enseignants", ["email" => "unit@testing.fr"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "enseignant/modified",
            "contenue" => "L'enseignant unit.testing unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
    }


    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionEnseignant()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->get("/scolarites/enseignants/{$enseignant->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$enseignant->nom} {$enseignant->prenom}" . "</b>.");
    }


    /**
     * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été supprimé
     */
    public function testTraitementSuppressionEnseignant()
    {
        $enseignant = factory(Enseignant::class)->create();

        $request = $this->delete("/scolarites/enseignants/{$enseignant->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("enseignants", ["email" => $enseignant->email]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "enseignant/deleted",
            "contenue" => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

}
