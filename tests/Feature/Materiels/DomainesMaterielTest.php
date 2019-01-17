<?php

namespace Tests\Feature;

use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainesMaterielTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexDomaines()
	{
		$Domaines = factory(DomaineMateriel::class, 5)->create();

		$request = $this->get("/materiels/domaines");

		$request->assertStatus(200);
		$request->assertSee("Gestion des domaines matériel");

		foreach ($Domaines as $Domaine) {
			$request->assertSee($Domaine->libelle);
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
		$request->assertSee("Créer le domaine");
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
		$Domaines = factory(DomaineMateriel::class, 5)->create();

		$request = $this->post("/materiels/domaines", [
			"_token" => csrf_token(),
			"libelle"    => $Domaines->random()->libelle,
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
			"_token"      => csrf_token(),
			"libelle"         => "unit.testing",
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
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->get("/materiels/domaines/{$Domaine->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Domaine->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Éditer le domaine");
		$request->assertSee("Supprimer le domaine");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionDomaineIncomplet()
	{
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$Domaine->id}", [
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
		$Domaines = factory(DomaineMateriel::class, 2)->create();

		$request = $this->put("/materiels/domaines/{$Domaines[0]->id}", [
			"_token"      => csrf_token(),
			"libelle"         => $Domaines[1]->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $Domaines[0]->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionDomaineCompletSansModification()
	{
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$Domaine->id}", [
			"_token"      => csrf_token(),
			"libelle"         => $Domaine->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $Domaine->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionDomaineCompletAvecModification()
	{
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/domaines/{$Domaine->id}", [
			"_token"      => csrf_token(),
			"libelle"         => "unit.testing",
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
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->get("/materiels/domaines/{$Domaine->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le domaine");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $Domaine->libelle . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le domaine n'à pas été supprimé s'il est associé à un type
	 */
	public function testTraitementSuppressionDomaineAssocie()
	{
		$Domaine = factory(DomaineMateriel::class)->create();
		$Type = factory(TypeMateriel::class)->create([
			"domaine_id" => $Domaine->id
		]);

		$request = $this->delete("/materiels/domaines/{$Domaine->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("domaines_materiels", ["libelle" => $Domaine->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le domaine à bien été supprimé s'il n'est associé à aucun
	 * type
	 */
	public function testTraitementSuppressionDomaineNonAssocie()
	{
		$Domaine = factory(DomaineMateriel::class)->create();

		$request = $this->delete("/materiels/domaines/{$Domaine->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("domaines_materiels", ["libelle" => $Domaine->libelle]);
	}

}
