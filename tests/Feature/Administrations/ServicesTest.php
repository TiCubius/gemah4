<?php

namespace Tests\Feature;

use App\Models\Departement;
use App\Models\Service;
use App\Models\Utilisateur;
use Tests\TestCase;

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
		$request->assertSee("Gestion des services");

		foreach ($Services as $Service) {
			$request->assertSee($Service->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationService()
	{
		$request = $this->get("/administrations/services/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un service");
		$request->assertSee("Nom");
		$request->assertSee("Département");
		$request->assertSee("Créer");
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
	 * d'un service déjà existant
	 */
	public function testTraitementFormulaireCreationServiceExistant()
	{
		$departement = factory(Departement::class)->create();
		$Services = factory(Service::class, 5)->create();

		$request = $this->post("/administrations/services", [
			"_token"         => csrf_token(),
			"nom"            => $Services->random()->nom,
			"departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un service à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationServiceComplet()
	{
		$departement = factory(Departement::class)->create();

		$request = $this->post("/administrations/services", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"description"    => "unit.testing",
			"departement_id" => $departement->id,
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
		$request->assertSee("Nom");
		$request->assertSee("Éditer");
		$request->assertSee("Département");
		$request->assertSee("Supprimer");
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
	 * d'un service déjà existant
	 */
	public function testTraitementFormulaireEditionServiceExistant()
	{
		$Services = factory(Service::class, 2)->create();

		$request = $this->put("/administrations/services/{$Services[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $Services[1]->nom,
			"description" => "unit.testing",
			"departement" => $Services[0]->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("services", ["nom" => $Services[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modifcication
	 */
	public function testTraitementFormulaireEditionServiceCompletSansModification()
	{
		$Service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token"         => csrf_token(),
			"nom"            => $Service->nom,
			"description"    => $Service->description,
			"departement_id" => $Service->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => $Service->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionServiceCompletAvecModification()
	{
		$departement = factory(Departement::class)->create();
		$Service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$Service->id}", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"description"    => "unit.testing",
			"departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionService()
	{
		$Service = factory(Service::class)->create();

		$request = $this->get("/administrations/services/{$Service->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le service");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $Service->nom . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le service n'est pas supprimé s'il est associé à des utilisateurs
	 */
	public function testTraitementSuppressionServiceAssocie()
	{
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create([
			"service_id" => $Service->id,
		]);

		$request = $this->delete("/administrations/services/{$Service->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("services", ["nom" => $Service->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionServiceNonAssocie()
	{
		$Service = factory(Service::class)->create();

		$request = $this->delete("/administrations/services/{$Service->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("services", ["nom" => $Service->nom]);
	}

}
