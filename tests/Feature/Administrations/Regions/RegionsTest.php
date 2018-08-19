<?php

namespace Tests\Feature;

use App\Models\Region;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionsTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index du menu Administration > Gestion des Regions
	 * sont bien celles attendues
	 */
	public function testAffichageIndexRegions()
	{
		$request = $this->get("/administrations/regions");

		$request->assertStatus(200);
		$request->assertSee("Liste des Régions");
	}

	/**
	 * Vérifie que le Formulaire de création d'une Region contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireAjoutRegion()
	{
		$request = $this->get("/administrations/regions/new");

		$request->assertStatus(200);
		$request->assertSee("Création d'une Région");
		$request->assertSee("Nom de la région");
		$request->assertSee("Créer la région");
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'une Region incomplet
	 */
	public function testTraitementFormulaireAjoutRegionIncomplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'ajout d'une Region complet
	 */
	public function testTraitementFormulaireAjoutRegionComplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'une Région déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireAjoutRegionExistante()
	{

		$this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
		]);

		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}
}
