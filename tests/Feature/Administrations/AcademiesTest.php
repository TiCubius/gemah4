<?php

namespace Tests\Feature\Administrations;

use App\Models\Academie;
use App\Models\Region;
use Tests\TestCase;

class AcademiesTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexAcademies()
	{
		$Region = factory(Region::class, 1)->create();
		$Academies = factory(Academie::class, 5)->create();

		$request = $this->get("/administrations/academies");

		$request->assertStatus(200);
		$request->assertSee("Gestion des académies");

		foreach ($Academies as $Academie) {
			$request->assertSee($Academie->nom);
			$request->assertSee($Academie->region->nom);
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
		$Region = factory(Region::class)->create();
		$Academies = factory(Academie::class, 5)->create();

		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => $Academies->random()->nom,
			"region" => $Region->id,
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
		$Region = factory(Region::class)->create();

		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionAcademie()
	{
		$Region = factory(Region::class)->create();
		$Academie = factory(Academie::class)->create();

		$request = $this->get("/administrations/academies/{$Academie->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Academie->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer l'académie");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionAcademieIncomplet()
	{
		$Region = factory(Region::class)->create();
		$Academie = factory(Academie::class)->create();

		$request = $this->put("/administrations/academies/{$Academie->id}", [
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
		$Region = factory(Region::class)->create();
		$Academies = factory(Academie::class, 2)->create();

		$request = $this->put("/administrations/academies/{$Academies[0]->id}", [
			"_token" => csrf_token(),
			"nom"    => $Academies[1]->nom,
			"region" => $Region->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("academies", ["nom" => $Academies[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'académie à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionAcademieCompletSansModification()
	{
		$Region = factory(Region::class)->create();
		$Academie = factory(Academie::class)->create([
			"region_id" => $Region->id,
		]);

		$request = $this->put("/administrations/academies/{$Academie->id}", [
			"_token" => csrf_token(),
			"nom"    => $Academie->nom,
			"region" => $Academie->region_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => $Academie->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'académie à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionAcademieCompletAvecModification()
	{
		$Region = factory(Region::class)->create();
		$Academie = factory(Academie::class)->create();

		$request = $this->put("/administrations/academies/{$Academie->id}", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
			"region" => $Region->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("academies", ["nom" => "unit.testing"]);
	}

}
