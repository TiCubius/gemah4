<?php

namespace Tests\Feature\Administrations;

use App\Models\Academie;
use App\Models\Departement;
use App\Models\Region;
use Tests\TestCase;

class AcademiesTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexAcademies()
	{
		$region = factory(Region::class, 1)->create();
		$academies = factory(Academie::class, 5)->create();

		$request = $this->get("/administrations/academies");

		$request->assertStatus(200);
		$request->assertSee("Gestion des académies");

		foreach ($academies as $academie) {
			$request->assertSee($academie->nom);
			$request->assertSee($academie->region->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationAcademie()
	{
		$request = $this->get("/administrations/academies/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'une académie");
		$request->assertSee("Nom");
		$request->assertSee("Région");
		$request->assertSee("Créer l'académie");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationAcademieIncomplet()
	{
		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'une académie déjà existante
	 */
	public function testTraitementFormulaireCreationAcademieExistante()
	{
		$region = factory(Region::class)->create();
		$academies = factory(Academie::class, 5)->create();

		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => $academies->random()->nom,
			"region" => $region->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'une académie à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationAcademieComplet()
	{
		$region = factory(Region::class)->create();

		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/created",
            "contenue" => "L'académie unit.testing à été créée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionAcademie()
	{
		$region = factory(Region::class)->create();
		$academie = factory(Academie::class)->create();

		$request = $this->get("/administrations/academies/{$academie->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de l'{$academie->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionAcademieIncomplet()
	{
		$region = factory(Region::class)->create();
		$academie = factory(Academie::class)->create();

		$request = $this->put("/administrations/academies/{$academie->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'une académie déjà existante
	 */
	public function testTraitementFormulaireEditionAcademieExistante()
	{
		$region = factory(Region::class)->create();
		$academies = factory(Academie::class, 2)->create();

		$request = $this->put("/administrations/academies/{$academies[0]->id}", [
			"_token" => csrf_token(),
			"nom"    => $academies[1]->nom,
			"region" => $region->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("academies", ["nom" => $academies[0]->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/modified",
            "contenue" => "L'académie {$academies[1]->nom} à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'académie à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionAcademieCompletSansModification()
	{
		$region = factory(Region::class)->create();
		$academie = factory(Academie::class)->create([
			"region_id" => $region->id,
		]);

		$request = $this->put("/administrations/academies/{$academie->id}", [
			"_token" => csrf_token(),
			"nom"    => $academie->nom,
			"region" => $academie->region_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => $academie->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/modified",
            "contenue" => "L'académie {$academie->nom} à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'académie à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionAcademieCompletAvecModification()
	{
		$region = factory(Region::class)->create();
		$academie = factory(Academie::class)->create();

		$request = $this->put("/administrations/academies/{$academie->id}", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
			"region" => $region->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/modified",
            "contenue" => "L'académie unit.testing à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionAcademie()
    {
        $academie = factory(Academie::class)->create();

        $request = $this->get("/administrations/academies/{$academie->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . $academie->nom . "</b>.");
    }

    /**
     * Vérifie que des erreurs sont présentes et que le service n'est pas supprimé s'il est associé à des départements
     */
    public function testTraitementSuppressionAcademieAssocie()
    {
        $academie = factory(Academie::class)->create();
        $departement = factory(Departement::class)->create([
            "academie_id" => $academie->id,
        ]);

        $request = $this->delete("/administrations/academies/{$academie->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("academies", ["nom" => $academie->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/deleted",
            "contenue" => "L'académie {$academie->nom} à été supprimée par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que le service à bien été supprimé s'il n'est associé à aucun
     * département
     */
    public function testTraitementSuppressionAcademieNonAssocie()
    {
        $academie = factory(Academie::class)->create();

        $request = $this->delete("/administrations/academies/{$academie->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("academies", ["nom" => $academie->nom]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "academie/deleted",
            "contenue" => "L'académie {$academie->nom} à été supprimée par {$this->user->nom} {$this->user->prenom}"
        ]);
    }
}
