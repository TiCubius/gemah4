<?php

namespace Tests\Feature;

use App\Models\Academie;
use App\Models\Service;
use App\Models\Utilisateur;
use App\Models\Region;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilisateursTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexUtilisateurs()
	{
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();
		$Utilisateurs = factory(Utilisateur::class, 5)->create();

		$request = $this->get("/administrations/utilisateurs");

		$request->assertStatus(200);
		$request->assertSee("Liste des Utilisateurs");

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
		$request = $this->get("/administrations/utilisateurs/new");

		$request->assertStatus(200);
		$request->assertSee("Création d'un Utilisateur");
		$request->assertSee("Nom de l'utilisateur");
		$request->assertSee("Prénom de l'utilisateur");
		$request->assertSee("Adresse E-Mail de l'utilisateur");
		$request->assertSee("Mot de passe de l'utilisateur");
		$request->assertSee("Confirmation du mot de passe de l'utilisateur");
		$request->assertSee("Académie de l'utilisateur");
		$request->assertSee("Service de l'utilisateur");
		$request->assertSee("Créer l'utilisateur");
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
	 * d'un Utilisateur déjà existante
	 */
	public function testTraitementFormulaireCreationUtilisateurExistant()
	{
		$Academie = factory(Academie::class)->create();
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
	 * Vérifie qu'aucune erreur n'est présente et qu'un Utilisateur à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationUtilisateurComplet()
	{
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();

		$request = $this->post("/administrations/utilisateurs", [
			"_token"                => csrf_token(),
			"nom"                   => "unit.testing",
			"prenom"                => "unit.testing",
			"email"                 => "unit@testing.fr",
			"password"              => "unit.testing",
			"password_confirmation" => "unit.testing",
			"academie"              => 1,
			"service"               => 1,
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
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->get("/administrations/utilisateurs/{$Utilisateur->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Utilisateur->nom}");
		$request->assertSee("Nom de l'utilisateur");
		$request->assertSee("Prénom de l'utilisateur");
		$request->assertSee("Adresse E-Mail de l'utilisateur");
		$request->assertSee("Académie de l'utilisateur");
		$request->assertSee("Service de l'utilisateur");
		$request->assertSee("Éditer l'utilisateur");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionUtilisateurIncomplet()
	{
		$Academie = factory(Academie::class)->create();
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
	 * d'un Utilisateur déjà existante
	 */
	public function testTraitementFormulaireEditionUtilisateurExistant()
	{
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();
		$Utilisateurs = factory(Utilisateur::class, 2)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateurs[0]->id}", [
			"_token"   => csrf_token(),
			"nom"      => "unit.testing",
			"prenom"   => "unit.testing",
			"email"    => $Utilisateurs[1]->email,
			"academie" => 1,
			"service"  => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("utilisateurs", ["nom" => $Utilisateurs[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'Utilisateur à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionUtilisateurCompletSansModification()
	{
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token"   => csrf_token(),
			"nom"      => $Utilisateur->nom,
			"prenom"   => $Utilisateur->prenom,
			"email"    => $Utilisateur->email,
			"academie" => $Utilisateur->academie_id,
			"service"  => $Utilisateur->service_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("utilisateurs", ["email" => $Utilisateur->email]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'Utilisateur à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionUtilisateurCompletAvecModification()
	{
		$Academie = factory(Academie::class)->create();
		$Service = factory(Service::class)->create();
		$Utilisateur = factory(Utilisateur::class)->create();

		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token"   => csrf_token(),
			"nom"      => "unit.testing",
			"prenom"   => "unit.testing",
			"email"    => "unit@testing.fr",
			"academie" => 1,
			"service"  => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("utilisateurs", ["email" => "unit@testing.fr"]);
	}

}
