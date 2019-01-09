<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Responsable;
use Tests\TestCase;

class ResponsablesTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexResponsables()
	{
		$Responsables = factory(Responsable::class, 5)->create();

		$request = $this->get("/responsables");

		$request->assertStatus(200);
		$request->assertSee("Gestion des responsables");

		foreach ($Responsables as $Responsable) {
			$request->assertSee($Responsable->nom);
			$request->assertSee($Responsable->prenom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationResponsable()
	{
		$request = $this->get("/responsables/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un responsable");
		$request->assertSee("Nom du responsable");
		$request->assertSee("Créer le responsable");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationResponsableIncomplet()
	{
		$request = $this->post("/responsables", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Responsable déjà existante
	 */
	public function testTraitementFormulaireCreationResponsableExistant()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->post("/responsables", [
			"_token"   => csrf_token(),
			"civilite" => "M",
			"nom"      => $Responsable->nom,
			"prenom"   => $Responsable->prenom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Responsable à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationResponsableComplet()
	{
		$request = $this->post("/responsables", [
			"_token"   => csrf_token(),
			"civilite" => "M",
			"nom"      => "unit.testing",
			"prenom"   => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("responsables", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionResponsable()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->get("/responsables/{$Responsable->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Responsable->nom}");
		$request->assertSee("Nom du responsable");
		$request->assertSee("Éditer le responsable");
		$request->assertSee("Supprimer le responsable");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionResponsableIncomplet()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->put("/responsables/{$Responsable->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Responsable déjà existante
	 */
	public function testTraitementFormulaireEditionResponsableExistant()
	{
		$Responsables = factory(Responsable::class, 2)->create();

		$request = $this->put("/responsables/{$Responsables[0]->id}", [
			"_token"   => csrf_token(),
			"civilite" => "M",
			"nom"      => $Responsables[1]->nom,
			"prenom"   => $Responsables[1]->prenom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("responsables", ["nom"    => $Responsables[0]->nom,
		                                          "prenom" => $Responsables[0]->prenom,
			]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Responsable à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionResponsableCompletSansModification()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->put("/responsables/{$Responsable->id}", [
			"_token"   => csrf_token(),
			"civilite" => $Responsable->civilite,
			"nom"      => $Responsable->nom,
			"prenom"   => $Responsable->prenom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("responsables", ["nom"    => $Responsable->nom,
		                                          "prenom" => $Responsable->prenom,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Responsable à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionResponsableCompletAvecModification()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->put("/responsables/{$Responsable->id}", [
			"_token"   => csrf_token(),
			"civilite" => "M",
			"nom"      => "unit.testing",
			"prenom"   => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("responsables", ["nom"    => "unit.testing",
		                                          "prenom" => "unit.testing",
		]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionResponsable()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->get("/responsables/{$Responsable->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le responsable");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . strtoupper("{$Responsable->nom} {$Responsable->prenom}") . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Responsable à bien été supprimé
	 */
	public function testTraitementSuppressionResponsableNonAssocie()
	{
		$Responsable = factory(Responsable::class)->create();

		$request = $this->delete("/responsables/{$Responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("responsables", ["nom"    => $Responsable->nom,
		                                              "prenom" => $Responsable->prenom,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Responsable à bien été supprimé
	 */
	public function testTraitementSuppressionResponsableAssocie()
	{
		$eleve = factory(Eleve::class)->create();
		$responsable = factory(Responsable::class)->create();

		$responsable->eleves()->attach($eleve);

		$request = $this->delete("/responsables/{$responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("responsables", ["nom"    => $responsable->nom,
		                                          "prenom" => $responsable->prenom,
		]);
	}

}
