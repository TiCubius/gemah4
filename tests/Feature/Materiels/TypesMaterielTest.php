<?php

namespace Tests\Feature;

use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypesMaterielTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypes()
	{
		$Domaines = factory(DomaineMateriel::class, 5)->create();
		$Types = factory(TypeMateriel::class, 5)->create([
			"domaine_id" => $Domaines->random()->id,
		]);

		$request = $this->get("/materiels/types");

		$request->assertStatus(200);
		$request->assertSee("Gestion des Types Matériel");

		foreach ($Types as $Type) {
			$request->assertSee($Type->nom);
			$request->assertSee($Type->domaine->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationType()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$request = $this->get("/materiels/types/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un Type");
		$request->assertSee("Nom du type");
		$request->assertSee("Domaine Matériel");
		$request->assertSee("Créer le type");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationTypeIncomplet()
	{
		$request = $this->post("/materiels/types", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Type déjà existant
	 */
	public function testTraitementFormulaireCreationTypeExistant()
	{
		$Domaine = factory(DomaineMateriel::class, 5)->create();
		$Types = factory(TypeMateriel::class, 5)->create([
			"domaine_id" => $Domaine->random()->id,
		]);

		$request = $this->post("/materiels/types", [
			"_token"  => csrf_token(),
			"nom"     => $Types->random()->nom,
			"domaine" => $Domaine->random()->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Type à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationTypeComplet()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$request = $this->post("/materiels/types", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiel", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionType()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create();

		$request = $this->get("/materiels/types/{$Type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Type->nom}");
		$request->assertSee("Nom du type");
		$request->assertSee("Domaine Matériel");
		$request->assertSee("Éditer le type");
		$request->assertSee("Supprimer le type");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionTypeIncomplet()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create();

		$request = $this->put("/materiels/types/{$Type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Type déjà existante
	 */
	public function testTraitementFormulaireEditionTypeExistant()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Types = factory(TypeMateriel::class, 2)->create();

		$request = $this->put("/materiels/types/{$Types[0]->id}", [
			"_token"  => csrf_token(),
			"nom"     => $Types[1]->nom,
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_materiel", ["nom" => $Types[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionTypeCompletSansModification()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create();

		$request = $this->put("/materiels/types/{$Type->id}", [
			"_token"  => csrf_token(),
			"nom"     => $Type->nom,
			"domaine" => $Type->domaine_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiel", ["nom" => $Type->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionTypeCompletAvecModification()
	{
		$Type = factory(TypeMateriel::class)->create();
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/types/{$Type->id}", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiel", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionType()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create();

		$request = $this->get("/materiels/types/{$Type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le type");
		$request->assertSee("Vous êtes sur le point de supprimer le type <b>" . strtoupper($Type->nom) . "</b>.");
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionType()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create();

		$request = $this->delete("/materiels/types/{$Type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("types_materiel", ["nom" => $Type->nom]);
	}

}
