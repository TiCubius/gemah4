<?php

namespace Tests\Feature\Administrations;

use App\Models\Service;
use App\Models\Utilisateur;
use Tests\TestCase;

class UtilisateursTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexUtilisateurs()
	{
		$Service = factory(Service::class)->create();
		$Utilisateurs = factory(Utilisateur::class, 5)->create();

		$request = $this->get("/administrations/utilisateurs");

		$request->assertStatus(200);
		$request->assertSee("Gestion des utilisateurs");

		foreach ($Utilisateurs as $Utilisateur) {
			$request->assertSee($Utilisateur->nom);
			$request->assertSee($Utilisateur->prenom);
			$request->assertSee($Utilisateur->service->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationUtilisateur()
	{
		$request = $this->get("/administrations/utilisateurs/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un utilisateur");
		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Adresse");
		$request->assertSee("Mot");
		$request->assertSee("Confirmation du mot de passe");
		$request->assertSee("Département");
		$request->assertSee("Service");
		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationUtilisateurIncomplet()
	{
		$request = $this->post("/administrations/utilisateurs", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un utilisateur déjà existant
	 */
	public function testTraitementFormulaireCreationUtilisateurExistant()
	{
		$Service = factory(Service::class)->create();
		$Utilisateurs = factory(Utilisateur::class, 5)->create();

		$request = $this->post("/administrations/utilisateurs", [
			"_token" => csrf_token(),
			"nom"    => $Utilisateurs->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un utilisateur à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationUtilisateurComplet()
	{
		$Service = factory(Service::class)->create();

		$request = $this->post("/administrations/utilisateurs", [
			"_token"                => csrf_token(),
			"nom"                   => "unit.testing",
			"prenom"                => "unit.testing",
			"email"                 => "unit@testing.fr",
			"password"              => "unit.testing",
			"password_confirmation" => "unit.testing",
			"service"               => $Service->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("utilisateurs", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionUtilisateur()
	{
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->get("/administrations/utilisateurs/{$Utilisateur->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Utilisateur->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Adresse E-Mail");
		$request->assertSee("Département");
		$request->assertSee("Service");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionUtilisateurIncomplet()
	{
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un utilisateur déjà existant
	 */
	public function testTraitementFormulaireEditionUtilisateurExistant()
	{
		$Service = factory(Service::class)->create();
		$Utilisateurs = factory(Utilisateur::class, 2)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateurs[0]->id}", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"prenom"  => "unit.testing",
			"email"   => $Utilisateurs[1]->email,
			"service" => $Service->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("utilisateurs", ["nom" => $Utilisateurs[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'utilisateur à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionUtilisateurCompletSansModification()
	{
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token"  => csrf_token(),
			"nom"     => $Utilisateur->nom,
			"prenom"  => $Utilisateur->prenom,
			"email"   => $Utilisateur->email,
			"service" => $Utilisateur->service_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("utilisateurs", ["email" => $Utilisateur->email]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'utilisateur à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionUtilisateurCompletAvecModification()
	{
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"prenom"  => "unit.testing",
			"email"   => "unit@testing.fr",
			"service" => $Service->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("utilisateurs", ["email" => "unit@testing.fr"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionUtilisateur()
	{
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->get("/administrations/utilisateurs/{$Utilisateur->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer l'utilisateur");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$Utilisateur->nom} {$Utilisateur->prenom}" . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que le utilisateur à bien été supprimé
	 */
	public function testTraitementSuppressionUtilisateur()
	{
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->delete("/administrations/utilisateurs/{$Utilisateur->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("utilisateurs", [
			"nom"    => $Utilisateur->nom,
			"prenom" => $Utilisateur->prenom,
		]);
	}


}
