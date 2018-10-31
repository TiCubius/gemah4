<?php

namespace Tests\Feature;

use App\Models\Enseignant;
use Tests\TestCase;

class EnseignantsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEnseignants()
	{
		$Enseignants = factory(Enseignant::class, 5)->create();

		$request = $this->get("/scolarites/enseignants");

		$request->assertStatus(200);
		$request->assertSee("Gestion des Enseignants");

		foreach ($Enseignants as $Enseignant) {
			$request->assertSee($Enseignant->nom);
			$request->assertSee($Enseignant->prenom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEnseignant()
	{
		$request = $this->get("/scolarites/enseignants/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un Enseignant");
		$request->assertSee("Nom de l'enseignant");
		$request->assertSee("Prénom de l'enseignant");
		$request->assertSee("Adresse E-Mail de l'enseignant");
		$request->assertSee("Téléphone de l'enseignant");
		$request->assertSee("Créer l'enseignant");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEnseignantIncomplet()
	{
		$request = $this->post("/scolarites/enseignants", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Enseignant déjà existante
	 */
	public function testTraitementFormulaireCreationEnseignantExistant()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->post("/scolarites/enseignants", [
			"_token"    => csrf_token(),
			"civilite"  => "Mme",
			"nom"       => $Enseignant->nom,
			"prenom"    => $Enseignant->prenom,
			"email"     => $Enseignant->email,
			"telephone" => $Enseignant->telephone,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Enseignant à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEnseignantComplet()
	{
		$request = $this->post("/scolarites/enseignants", [
			"_token"    => csrf_token(),
			"civilite"  => "Mme",
			"nom"       => "unit.testing",
			"prenom"    => "unit.testing",
			"email"     => "unit@testing.fr",
			"telephone" => "0123456789",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("enseignants", ["email" => "unit@testing.fr"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEnseignant()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->get("/scolarites/enseignants/{$Enseignant->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Enseignant->nom}");
		$request->assertSee("Nom de l'enseignant");
		$request->assertSee("Prénom de l'enseignant");
		$request->assertSee("Adresse E-Mail de l'enseignant");
		$request->assertSee("Téléphone de l'enseignant");
		$request->assertSee("Éditer l'enseignant");
		$request->assertSee("Supprimer l'enseignant");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEnseignantIncomplet()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->put("/scolarites/enseignants/{$Enseignant->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Enseignant déjà existante
	 */
	public function testTraitementFormulaireEditionEnseignantExistant()
	{
		$Enseignants = factory(Enseignant::class, 2)->create();

		$request = $this->put("/scolarites/enseignants/{$Enseignants[0]->id}", [
			"_token"    => csrf_token(),
			"civilite"  => $Enseignants[1]->civilite,
			"nom"       => $Enseignants[1]->nom,
			"prenom"    => $Enseignants[1]->prenom,
			"email"     => $Enseignants[1]->email,
			"telephone" => $Enseignants[1]->telephone,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("enseignants", ["nom" => $Enseignants[0]->nom, "prenom" => $Enseignants[0]->prenom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEnseignantCompletSansModification()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->put("/scolarites/enseignants/{$Enseignant->id}", [
			"_token"    => csrf_token(),
			"civilite"  => $Enseignant->civilite,
			"nom"       => $Enseignant->nom,
			"prenom"    => $Enseignant->prenom,
			"email"     => $Enseignant->email,
			"telephone" => $Enseignant->telephone,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("enseignants", ["nom" => $Enseignant->nom, "prenom" => $Enseignant->prenom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEnseignantCompletAvecModification()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->put("/scolarites/enseignants/{$Enseignant->id}", [
			"_token"    => csrf_token(),
			"civilite"  => "M",
			"nom"       => "unit.testing",
			"prenom"    => "unit.testing",
			"email"     => "unit@testing.fr",
			"telephone" => "0123456789",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("enseignants", ["email" => "unit@testing.fr"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEnseignant()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->get("/scolarites/enseignants/{$Enseignant->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer l'enseignant");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . strtoupper("{$Enseignant->nom} {$Enseignant->prenom}") . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'enseignant à bien été supprimé
	 */
	public function testTraitementSuppressionEnseignant()
	{
		$Enseignant = factory(Enseignant::class)->create();

		$request = $this->delete("/scolarites/enseignants/{$Enseignant->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("enseignants", ["email" => $Enseignant->email]);
	}

}
