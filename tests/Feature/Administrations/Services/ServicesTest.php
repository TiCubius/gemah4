<?php

namespace Tests\Feature;

use App\Models\Service;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicesTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexServices()
	{
		$Services = factory(Service::class, 5)->create();

		$request = $this->get("/administrations/services");

		$request->assertStatus(200);
		$request->assertSee("Liste des Services");

		foreach ($Services as $Service) {
			$request->assertSee($Service->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationService()
	{
		$request = $this->get("/administrations/services/new");

		$request->assertStatus(200);
		$request->assertSee("Création d'un Service");
		$request->assertSee("Nom du service");
		$request->assertSee("Créer le service");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationServiceIncomplet()
	{
		$request = $this->post("/administrations/services", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Service déjà existante
	 */
	public function testTraitementFormulaireCreationServiceExistant()
	{
		$Services = factory(Service::class, 5)->create();

		$request = $this->post("/administrations/services", [
			"_token" => csrf_token(),
			"nom"    => $Services->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Service à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationServiceComplet()
	{
		$request = $this->post("/administrations/services", [
			"_token"      => csrf_token(),
			"nom"         => "unit.testing",
			"description" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
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
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
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
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Service déjà existante
	 */
	public function testTraitementFormulaireEditionServiceExistant()
	{
		$Services = factory(Service::class, 2)->create();

		$request = $this->put("/administrations/services/{$Services[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $Services[1]->nom,
			"description" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("services", ["nom" => $Services[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Service à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionServiceCompletSansModification()
	{
		$Service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token"      => csrf_token(),
			"nom"         => $Service->nom,
			"description" => $Service->description,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => $Service->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Service à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionServiceCompletAvecModification()
	{
		$Service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token"      => csrf_token(),
			"nom"         => "unit.testing",
			"description" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => "unit.testing"]);
	}

}
