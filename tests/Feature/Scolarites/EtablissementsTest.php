<?php

namespace Tests\Feature\Scolarites;

use App\Models\Departement;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\TypeEtablissement;
use Tests\TestCase;

class EtablissementsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEtablissements()
	{
		$etablissements = factory(Etablissement::class, 5)->create();

		$request = $this->get("/scolarites/etablissements");

		$request->assertStatus(200);
		$request->assertSee("Gestion des établissements");

		foreach ($etablissements as $etablissement) {
			$request->assertSee($etablissement->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEtablissement()
	{
		$request = $this->get("/scolarites/etablissements/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un établissement");
		$request->assertSee("Nom");
		$request->assertSee("Type");
		$request->assertSee("Code");
		$request->assertSee("Degré");
		$request->assertSee("Régime");
		$request->assertSee("Ville");
		$request->assertSee("Code Postal");
		$request->assertSee("Adresse");
		$request->assertSee("Téléphone");
		$request->assertSee("Enseignant Référent");
		$request->assertSee("Département");
		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEtablissementIncomplet()
	{
		$request = $this->post("/scolarites/etablissements", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Etablissement déjà existante
	 */
	public function testTraitementFormulaireCreationEtablissementExistant()
	{
		$departement = factory(Departement::class)->create();
		$enseignant = factory(Enseignant::class)->create();
		$etablissement = factory(Etablissement::class)->create();
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->post("/scolarites/etablissements", [
			"_token"                => csrf_token(),
			"departement_id"        => $departement->id,
			"enseignant_id"         => $enseignant->id,
			"type_etablissement_id" => $type->id,

			"id"          => $etablissement->id,
			"nom"         => "unit.testing",
			"degre"       => "second",
			"regime"      => "Privé",
			"ville"       => "unit.testing",
			"code_postal" => "42000",
			"adresse"     => "unit.testing",
			"telephone"   => "0123456789",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Etablissement à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEtablissementComplet()
	{
		$departement = factory(Departement::class)->create();
		$enseignant = factory(Enseignant::class)->create();
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->post("/scolarites/etablissements", [
			"_token"                => csrf_token(),
			"departement_id"        => $departement->id,
			"enseignant_id"         => $enseignant->id,
			"type_etablissement_id" => $type->id,

			"id"          => "UT",
			"nom"         => "unit.testing",
			"degre"       => "second",
			"regime"      => "Privé",
			"ville"       => "unit.testing",
			"code_postal" => "42000",
			"adresse"     => "unit.testing",
			"telephone"   => "0123456789",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etablissements", ["id" => "UT"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEtablissement()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->get("/scolarites/etablissements/{$etablissement->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$etablissement->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Type");
		$request->assertSee("Code");
		$request->assertSee("Degré");
		$request->assertSee("Régime");
		$request->assertSee("Ville");
		$request->assertSee("Code Postal");
		$request->assertSee("Adresse");
		$request->assertSee("Téléphone");
		$request->assertSee("Enseignant Référent");
		$request->assertSee("Département");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEtablissementIncomplet()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->put("/scolarites/etablissements/{$etablissement->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Etablissement déjà existante
	 */
	public function testTraitementFormulaireEditionEtablissementExistant()
	{
		$departement = factory(Departement::class)->create();
		$enseignant = factory(Enseignant::class)->create();
		$etablissements = factory(Etablissement::class, 2)->create();
		$type = factory(TypeEtablissement::class)->create();

		$request = $this->put("/scolarites/etablissements/{$etablissements[1]->id}", [
			"_token"                => csrf_token(),
			"departement_id"        => $departement->id,
			"enseignant_id"         => $enseignant->id,
			"type_etablissement_id" => $type->id,

			"id"          => $etablissements[0]->id,
			"nom"         => "unit.testing",
			"degre"       => "second",
			"regime"      => "Privé",
			"ville"       => "unit.testing",
			"code_postal" => "42000",
			"adresse"     => "unit.testing",
			"telephone"   => "0123456789",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("etablissements", [
			"id"    => $etablissements[0]->id,
			"ville" => $etablissements[0]->ville,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'établissement à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEtablissementCompletSansModification()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->put("/scolarites/etablissements/{$etablissement->id}", [
			"_token"                => csrf_token(),
			"id"                    => $etablissement->id,
			"nom"                   => $etablissement->nom,
			"type_etablissement_id" => $etablissement->type_etablissement_id,
			"degre"                 => $etablissement->degre,
			"regime"                => $etablissement->regime,
			"ville"                 => $etablissement->ville,
			"code_postal"           => $etablissement->code_postal,
			"adresse"               => $etablissement->adresse,
			"telephone"             => $etablissement->telephone,
			"enseignant_id"         => $etablissement->enseignant_id,
			"departement_id"        => $etablissement->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etablissements", [
			"id"  => $etablissement->id,
			"nom" => $etablissement->nom,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'établissement à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEtablissementCompletAvecModification()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->put("/scolarites/etablissements/{$etablissement->id}", [
			"_token"                => csrf_token(),
			"id"                    => $etablissement->id,
			"nom"                   => "unit.testing",
			"type_etablissement_id" => $etablissement->type_etablissement_id,
			"degre"                 => $etablissement->degre,
			"regime"                => $etablissement->regime,
			"ville"                 => $etablissement->ville,
			"code_postal"           => $etablissement->code_postal,
			"adresse"               => $etablissement->adresse,
			"telephone"             => $etablissement->telephone,
			"enseignant_id"         => $etablissement->enseignant_id,
			"departement_id"        => $etablissement->departement_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etablissements", [
			"id"  => $etablissement->id,
			"nom" => "unit.testing",
		]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEtablissement()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->get("/scolarites/etablissements/{$etablissement->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$etablissement->nom}" . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'établissement à bien été supprimé
	 */
	public function testTraitementSuppressionEtablissement()
	{
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->delete("/scolarites/etablissements/{$etablissement->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("etablissements", ["code" => $etablissement->code]);
	}

}
