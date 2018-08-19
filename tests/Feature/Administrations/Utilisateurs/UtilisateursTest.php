<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilisateursTest extends TestCase
{
	/**
	 * Test l'index du menu Utilisateurs
	 * Il est composé de la liste de tout les utilisateurs de l'application, et des liens pour les modifier ou supprimer.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get("/administrations/utilisateurs");

		$request->assertStatus(200);
		$request->assertSee("Liste des Utilisateurs");
	}

	/**
	 * Test le formulaire de création d'un utilisateur
	 * Il est composé des différents champs associés à un utilisateur
	 *
	 * @return void
	 */
	public function testFormulaireCreation()
	{
		$request = $this->get("/administrations/utilisateurs/new");

		$request->assertStatus(200);
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
	 * Test l'échec de création d'un utilisateur dans le cas où des données seraient manquantes
	 */
	public function testEchecCreationUtilisateur()
	{
		$request = $this->post("/administrations/utilisateurs", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	public function testSuccesCreationUtilisateur()
	{
		$request = $this->post("/administrations/utilisateurs", [
			"_token"           => csrf_token(),
			"nom"              => "Unit",
			"prenom"           => "Testing",
			"email"            => "ut@exemple.fr",
			"password"         => "unittesting",
			"password_confirm" => "unittesting",
			"academie"         => 1,
			"service"          => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();

    }
}
