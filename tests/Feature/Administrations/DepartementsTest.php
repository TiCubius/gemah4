<?php

namespace Tests\Feature;

use App\Models\Academie;
use App\Models\Departement;
use App\Models\Region;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
            "_token"    => csrf_token(),
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
            "_token"    => csrf_token(),
            "id"        => $departements->random()->id,
            "nom"       => $departements->random()->nom,
            "academie"  => $academie->id,
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
            "_token"    => csrf_token(),
            "id"        => "unit.testing",
            "nom"       => "unit.testing",
            "academie"  => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id" => "unit.testing",
            "nom" => "unit.testing"
        ]);
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
            "_token"    => csrf_token(),
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
            "_token"    => csrf_token(),
            "id"        => $departements[1]->id,
            "nom"       => $departements[1]->nom,
            "academie"  => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("departements", [
            "id" => $departements[0]->id,
            "nom" => $departements[0]->nom
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
            "academie_id" => $academie->id
        ]);

        $request = $this->put("/administrations/departements/{$departement->id}", [
            "_token"    => csrf_token(),
            "id"        => $departement->id,
            "nom"       => $departement->nom,
            "academie"  => $departement->academie_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id"    => $departement->id,
            "nom"   => $departement->nom
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
            "_token"    => csrf_token(),
            "id"        => "unit.testing",
            "nom"       => "unit.testing",
            "academie"  => $academie->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("departements", [
            "id" => "unit.testing",
            "nom" => "unit.testing"
        ]);
    }
}

?>