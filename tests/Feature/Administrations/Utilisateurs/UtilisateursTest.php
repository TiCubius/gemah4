<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilisateursTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index du menu Administration > Gestion des Utilisateurs
	 * sont bien celles attendues
	 */
	public function testAffichageIndexUtilisateurs()
	{
		$request = $this->get("/administrations/utilisateurs");

		$request->assertStatus(200);
		$request->assertSee("Liste des Utilisateurs");
	}

	/**
	 * Vérifie que le Formulaire de création d'un Utilisateur contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireAjoutUtilisateur()
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
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'un Utilisateur incomplet
	 */
	public function testTraitementFormulaireAjoutUtilisateurIncomplet()
	{
		$request = $this->post("/administrations/utilisateurs", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'ajout d'un Utilisateur complet
	 */
	public function testTraitementFormulaireAjoutUtilisateurComplet()
	{
		$request = $this->post("/administrations/utilisateurs", [
			"_token"                => csrf_token(),
			"nom"                   => "Unit",
			"prenom"                => "Testing",
			"email"                 => "ut@exemple.fr",
			"password"              => "unittesting",
			"password_confirmation" => "unittesting",
			"academie"              => 1,
			"service"               => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'ajout d'un Utilisateur déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireAjoutUtilisateurExistante()
	{

		$this->post("/administrations/utilisateurs", [
			"_token"                => csrf_token(),
			"nom"                   => "Unit",
			"prenom"                => "Testing",
			"email"                 => "ut@exemple.fr",
			"password"              => "unittesting",
			"password_confirmation" => "unittesting",
			"academie"              => 1,
			"service"               => 1,
		]);

		$request = $this->post("/administrations/utilisateurs", [
			"_token"                => csrf_token(),
			"nom"                   => "Unit",
			"prenom"                => "Testing",
			"email"                 => "ut@exemple.fr",
			"password"              => "unittesting",
			"password_confirmation" => "unittesting",
			"academie"              => 1,
			"service"               => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que le Formulaire d'édition d'un Utilisateur contient bien les champs nécessaire
	 */
	public function testAffichageFormulaireEditionUtilisateur()
	{
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
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'un Utilisateur incomplet
	 */
	public function testTraitementFormulaireEditionUtilisateurIncomplet()
	{
		$Utilisateur = factory(Utilisateur::class)->create();
		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}


	/**
	 * Vérifie que l'utilisateur est bien redirigé et qu'aucune erreur n'est présente lors de la soumission d'un
	 * formulaire d'édition d'un Utilisateur complet
	 */
	public function testTraitementFormulaireEditionUtilisateurComplet()
	{
		$Utilisateur = factory(Utilisateur::class)->create();
		$request = $this->put("/administrations/utilisateurs/{$Utilisateur->id}", [
			"_token"                => csrf_token(),
			"nom"                   => "Unit",
			"prenom"                => "Testing",
			"email"                 => "ut@exemple.fr",
			"password"              => "unittesting",
			"password_confirmation" => "unittesting",
			"academie"              => 1,
			"service"               => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que l'utilisateur est bien redirigé et que les erreurs sont bien présentes lors de la tentative
	 * de soumission d'un formulaire d'édition d'un Utilisateur déjà présente dans la base de donnée
	 */
	public function testTraitementFormulaireEditionUtilisateurExistante()
	{
		$Utilisateurs = factory(Utilisateur::class, 2)->create();
		$request = $this->put("/administrations/utilisateurs/{$Utilisateurs[0]->id}", [
			"_token"                => csrf_token(),
			"nom"                   => "Unit",
			"prenom"                => "Testing",
			"email"                 => $Utilisateurs[1]->email,
			"password"              => "unittesting",
			"password_confirmation" => "unittesting",
			"academie"              => 1,
			"service"               => 1,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}
}
