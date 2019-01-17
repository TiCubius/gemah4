<?php

namespace Tests\Feature;

use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\TypeEtablissement;
use App\Models\Utilisateur;
use Tests\TestCase;

class TypeEtablissementTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypeEtablissements()
	{
		$types = factory(TypeEtablissement::class, 5)->create();

		$request = $this->get("/administrations/etablissements/types");

		$request->assertStatus(200);
		$request->assertSee("Gestion des types d'établissements");

		foreach ($types as $type) {
			$request->assertSee($type->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationTypeEtablissement()
	{
		$request = $this->get("/administrations/etablissements/types/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un type d'établissement");
		$request->assertSee("Nom");
		$request->assertSee("Créer le type d'établissement");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationTypeEtablissementIncomplet()
	{
		$request = $this->post("/administrations/etablissements/types", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un type d'établissement déjà existant
	 */
	public function testTraitementFormulaireCreationTypeEtablissementExistant()
	{
		$types = factory(TypeEtablissement::class, 5)->create();

		$request = $this->post("/administrations/etablissements/types", [
			"_token"         => csrf_token(),
			"nom"            => $types->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un type d'établissement à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationTypeEtablissementComplet()
	{
		$request = $this->post("/administrations/etablissements/types", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_etablissements", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionTypeEtablissement()
	{
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->get("/administrations/etablissements/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$type->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionTypeEtablissementIncomplet()
	{
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->put("/administrations/etablissements/types/{$type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un typed'établissement déjà existant
	 */
	public function testTraitementFormulaireEditionTypeEtablissementExistant()
	{
		$types = factory(TypeEtablissement::class, 2)->create();

		$request = $this->put("/administrations/etablissements/types/{$types[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $types[1]->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_etablissements", ["nom" => $types[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'établissement à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionTypeEtablissementCompletSansModification()
	{
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->put("/administrations/etablissements/types/{$type->id}", [
			"_token"         => csrf_token(),
			"nom"            => $type->nom,
			"description"    => $type->description,
			"departement_id" => $type->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_etablissements", ["nom" => $type->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'établissement à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionTypeEtablissementCompletAvecModification()
	{
		$departement = factory(Departement::class)->create();
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->put("/administrations/etablissements/types/{$type->id}", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"description"    => "unit.testing",
			"departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_etablissements", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionTypeEtablissement()
	{
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->get("/administrations/etablissements/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $type->nom . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le type d'établissement n'est pas supprimé s'il est associé à des utilisateurs
	 */
	public function testTraitementSuppressionTypeEtablissementAssocie()
	{
		$type = factory(TypeEtablissement::class)->create();
		$etablissement = factory(Etablissement::class)->create([
			"type_etablissement_id" => $type->id,
		]);

		$request = $this->delete("/administrations/etablissements/types/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_etablissements", ["nom" => $type->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'établissement à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionTypeEtablissementNonAssocie()
	{
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->delete("/administrations/etablissements/types/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("types_etablissements", ["nom" => $type->nom]);
	}

}
