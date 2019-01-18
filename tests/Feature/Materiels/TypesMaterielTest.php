<?php

namespace Tests\Feature;

use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Tests\TestCase;

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
		$request->assertSee("Gestion des types matériel");

		foreach ($Types as $Type) {
			$request->assertSee($Type->libelle);
			$request->assertSee($Type->domaine->libelle);
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
		$request->assertSee("Création d'un type matériel");
		$request->assertSee("Libellé");
		$request->assertSee("Domaine");
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
			"libelle" => $Types->random()->libelle,
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
			"libelle" => "unit.testing",
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => "unit.testing"]);
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
		$request->assertSee("Édition de {$Type->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Domaine");
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
			"libelle" => $Types[1]->libelle,
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => $Types[0]->libelle]);
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
			"libelle" => $Type->libelle,
			"domaine" => $Type->domaine_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => $Type->libelle]);
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
			"libelle" => "unit.testing",
			"domaine" => $Domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => "unit.testing"]);
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
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $Type->libelle . "</b>.");
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
		$this->assertDatabaseMissing("types_materiels", ["libelle" => $Type->libelle]);
	}

}
