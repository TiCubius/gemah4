<?php

namespace Tests\Feature;

use App\Models\Academie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcademiesTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index du menu Administration > Gestion des Académies
	 * sont bien celles attendues
	 */
	public function testAffichageIndexAcademies()
	{
		$request = $this->get("/administrations/academies");

		$request->assertStatus(200);
		$request->assertSee("Liste des Académies");
	}


	/**
	 * Vérifie que le Formulaire de création d'une Académie contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireAjoutAcademie()
	{
		$request = $this->get("/administrations/academies/new");

		$request->assertStatus(200);
		$request->assertSee("Création d'une Académie");
		$request->assertSee("Nom de l'académie");
		$request->assertSee("Région de l'académie");
		$request->assertSee("Créer l'académie");
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'une Académie incomplet
	 */
	public function testTraitementFormulaireAjoutAcademieIncomplet()
	{
		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'ajout d'une Académie complet
	 */
	public function testTraitementFormulaireAjoutAcademieComplet()
	{
		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'une Académie déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireAjoutAcademieExistante()
	{

		$this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
			"region" => 1,
		]);

		$request = $this->post("/administrations/academies", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que le Formulaire d'édition d'une Académie contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireEditionAcademie()
	{
		$Academie = factory(Academie::class)->create();
		$request = $this->get("/administrations/academies/{$Academie->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Academie->nom}");
		$request->assertSee("Nom de l'académie");
		$request->assertSee("Éditer l'académie");
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'une Académie incomplet
	 */
	public function testTraitementFormulaireEditionAcademieIncomplet()
	{
		$Academie = factory(Academie::class)->create();
		$request = $this->put("/administrations/academies/{$Academie->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'édition d'une Académie complet
	 */
	public function testTraitementFormulaireEditionAcademieComplet()
	{
		$Academie = factory(Academie::class)->create();
		$request = $this->put("/administrations/academies/{$Academie->id}", [
			"_token" => csrf_token(),
			"nom"    => "Unit",
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'une Académie déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireEditionAcademieExistante()
	{
		$Academies = factory(Academie::class, 2)->create();
		$request = $this->put("/administrations/academies/{$Academies[0]->id}", [
			"_token" => csrf_token(),
			"nom"    => $Academies[1]->nom,
			"region" => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}
}
