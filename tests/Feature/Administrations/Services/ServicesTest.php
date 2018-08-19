<?php

namespace Tests\Feature;

use App\Models\Service;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicesTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index du menu Administration > Gestion des Services
	 * sont bien celles attendues
	 */
	public function testAffichageIndexServices()
	{
		$request = $this->get("/administrations/services");

		$request->assertStatus(200);
		$request->assertSee("Liste des Services");
	}

	/**
	 * Vérifie que le Formulaire de création d'un Service contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireAjoutService()
	{
		$request = $this->get("/administrations/services/new");

		$request->assertStatus(200);
		$request->assertSee("Création d'un Service");
		$request->assertSee("Nom du service");
		$request->assertSee("Description du service");
		$request->assertSee("Créer le service");
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'un Service incomplet
	 */
	public function testTraitementFormulaireAjoutServiceIncomplet()
	{
		$request = $this->post("/administrations/services", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'ajout d'un Service complet
	 */
	public function testTraitementFormulaireAjoutServiceComplet()
	{
		$request = $this->post("/administrations/services", [
			"_token"      => csrf_token(),
			"nom"         => "Unit",
			"description" => "Unit",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'un Service déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireAjoutServiceExistante()
	{

		$this->post("/administrations/services", [
			"_token"      => csrf_token(),
			"nom"         => "Unit",
			"description" => "Unit",
		]);

		$request = $this->post("/administrations/services", [
			"_token"      => csrf_token(),
			"nom"         => "Unit",
			"description" => "Unit",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que le Formulaire d'édition d'un Service contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireEditionService()
	{
		$Service = factory(Service::class)->create();
		$request = $this->get("/administrations/services/{$Service->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Service->nom}");
		$request->assertSee("Nom du service");
		$request->assertSee("Éditer le service");
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'un Service incomplet
	 */
	public function testTraitementFormulaireEditionServiceIncomplet()
	{
		$Service = factory(Service::class)->create();
		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'édition d'un Service complet
	 */
	public function testTraitementFormulaireEditionServiceComplet()
	{
		$Service = factory(Service::class)->create();
		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token"      => csrf_token(),
			"nom"         => "Unit",
			"description" => "Testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'un Service déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireEditionServiceExistante()
	{
		$Services = factory(Service::class, 2)->create();
		$request = $this->put("/administrations/services/{$Services[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $Services[1]->nom,
			"description" => "Testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}
}
