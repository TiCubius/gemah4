<?php

namespace Tests\Feature\Administrations;

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
		$services = factory(Service::class, 5)->create();

		$request = $this->get("/administrations/services");

		$request->assertStatus(200);
		$request->assertSee("Gestion des services");

		foreach ($services as $service) {
			$request->assertSee($service->nom);
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
		$services = factory(Service::class, 5)->create();

		$request = $this->post("/administrations/services", [
			"_token"         => csrf_token(),
			"nom"            => $services->random()->nom,
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
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/created",
            "information" => "Le service unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

    /**
     * Vérifie que les données présentes sur le profil sont bien celles attendues
     */
    public function testAffichageProfilService()
    {
        $service = factory(Service::class)->create();
        $utilisateurs = factory(Utilisateur::class, 2)->create([
            "service_id" => $service->id
        ]);

        $request = $this->get("/administrations/services/{$service->id}");

        $request->assertStatus(200);
        $request->assertSee("Profil du service \"{$service->nom}\"");

        $request->assertSee("Utilisateurs");
        $request->assertSee("Action");
        foreach ($utilisateurs as $utilisateur)
        {
            $request->assertSee($utilisateur->nom);
            $request->assertSee($utilisateur->prenom);
            $request->assertSee($utilisateur->email);
            $request->assertSee("Détails");
        }
    }

	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionService()
	{
		$service = factory(Service::class)->create();

		$request = $this->get("/administrations/services/{$service->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$service->nom}");
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
		$service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$service->id}", [
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
		$services = factory(Service::class, 2)->create();

		$request = $this->put("/administrations/services/{$services[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $services[1]->nom,
			"description" => "unit.testing",
			"departement" => $services[0]->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("services", ["nom" => $services[0]->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/modified",
            "information" => "Le service {$services[1]->nom} à été modifié {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modifcication
	 */
	public function testTraitementFormulaireEditionServiceCompletSansModification()
	{
		$service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$service->id}", [
			"_token"         => csrf_token(),
			"nom"            => $service->nom,
			"description"    => $service->description,
			"departement_id" => $service->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => $service->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/modified",
            "information" => "Le service {$service->nom} à été modifié {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionServiceCompletAvecModification()
	{
		$departement = factory(Departement::class)->create();
		$service = factory(Service::class)->create();

		$request = $this->put("/administrations/services/{$service->id}", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"description"    => "unit.testing",
			"departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("services", ["nom" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/modified",
            "information" => "Le service unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionService()
	{
		$service = factory(Service::class)->create();

		$request = $this->get("/administrations/services/{$service->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $service->nom . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le service n'est pas supprimé s'il est associé à des utilisateurs
	 */
	public function testTraitementSuppressionServiceAssocie()
	{
		$service = factory(Service::class)->create();
		$utilisateur = factory(Utilisateur::class)->create([
			"service_id" => $service->id,
		]);

		$request = $this->delete("/administrations/services/{$service->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("services", ["nom" => $service->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/deleted",
            "information" => "Le service {$service->nom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le service à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionServiceNonAssocie()
	{
		$service = factory(Service::class)->create();

		$request = $this->delete("/administrations/services/{$service->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("services", ["nom" => $service->nom]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "service/deleted",
            "information" => "Le service {$service->nom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

}
