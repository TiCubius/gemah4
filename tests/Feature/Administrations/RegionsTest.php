<?php

namespace Tests\Feature\Administrations;

use App\Models\Region;
use Tests\TestCase;

class RegionsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexRegions()
	{
		$Regions = factory(Region::class, 5)->create();

		$request = $this->get("/administrations/regions");

		$request->assertStatus(200);
		$request->assertSee("Gestion des régions");

		foreach ($Regions as $Region) {
			$request->assertSee($Region->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationRegion()
	{
		$request = $this->get("/administrations/regions/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'une région");
		$request->assertSee("Nom");
		$request->assertSee("Créer la région");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationRegionIncomplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'une région déjà existante
	 */
	public function testTraitementFormulaireCreationRegionExistante()
	{
		$Regions = factory(Region::class, 5)->create();

		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => $Regions->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'une région à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationRegionComplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionRegion()
	{
		$Region = factory(Region::class)->create();

		$request = $this->get("/administrations/regions/{$Region->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Region->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer la région");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionRegionIncomplet()
	{
		$Region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$Region->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'une région déjà existante
	 */
	public function testTraitementFormulaireEditionRegionExistante()
	{
		$Regions = factory(Region::class, 2)->create();

		$request = $this->put("/administrations/regions/{$Regions[0]->id}", [
			"_token" => csrf_token(),
			"nom"    => $Regions[1]->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("regions", ["nom" => $Regions[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la région à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionRegionCompletSansModification()
	{
		$Region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$Region->id}", [
			"_token" => csrf_token(),
			"nom"    => $Region->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => $Region->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la région à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionRegionCompletAvecModification()
	{
		$Region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$Region->id}", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => "unit.testing"]);
	}

}
