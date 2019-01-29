<?php

namespace Tests\Feature\Materiels;

use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Tests\TestCase;

class DomainesMaterielTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexDomaines()
	{
		$domaines = factory(DomaineMateriel::class, 5)->create();

		$request = $this->get("/materiels/domaines");

		$request->assertStatus(200);
		$request->assertSee("Gestion des domaines matériel");

		foreach ($domaines as $domaine) {
			$request->assertSee($domaine->libelle);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationDomaine()
	{
		$request = $this->get("/materiels/domaines/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un domaine matériel");
		$request->assertSee("Libellé");
		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationDomaineIncomplet()
	{
		$request = $this->post("/materiels/domaines", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un domaine déjà existant
	 */
	public function testTraitementFormulaireCreationDomaineExistant()
	{
		$domaines = factory(DomaineMateriel::class, 5)->create();

		$request = $this->post("/materiels/domaines", [
			"_token"  => csrf_token(),
			"libelle" => $domaines->random()->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un domaine à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationDomaineComplet()
	{
		$request = $this->post("/materiels/domaines", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionDomaine()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->get("/materiels/domaines/{$domaine->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$domaine->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionDomaineIncomplet()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$domaine->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un domaine déjà existant
	 */
	public function testTraitementFormulaireEditionDomaineExistant()
	{
		$domaines = factory(DomaineMateriel::class, 2)->create();

		$request = $this->put("/materiels/domaines/{$domaines[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $domaines[1]->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $domaines[0]->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionDomaineCompletSansModification()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$domaine->id}", [
			"_token"  => csrf_token(),
			"libelle" => $domaine->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $domaine->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionDomaineCompletAvecModification()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$domaine->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionDomaine()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->get("/materiels/domaines/{$domaine->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $domaine->libelle . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le domaine n'à pas été supprimé s'il est associé à un type
	 */
	public function testTraitementSuppressionDomaineAssocie()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create([
			"domaine_id" => $domaine->id,
		]);

		$request = $this->delete("/materiels/domaines/{$domaine->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $domaine->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été supprimé s'il n'est associé à aucun
	 * type
	 */
	public function testTraitementSuppressionDomaineNonAssocie()
	{
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->delete("/materiels/domaines/{$domaine->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("domaines_materiels", ["libelle" => $domaine->libelle]);
	}

}
