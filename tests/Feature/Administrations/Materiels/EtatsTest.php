<?php

namespace Tests\Feature;

use App\Models\EtatMateriel;
use Tests\TestCase;

class EtatsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEtatMateriels()
	{
		$Etats = factory(EtatMateriel::class, 5)->create();

		$request = $this->get("/administrations/materiels/etats");

		$request->assertStatus(200);
		$request->assertSee("Gestion des états matériel");

		foreach ($Etats as $Etat) {
			$request->assertSee($Etat->nom);
			$request->assertSee($Etat->couleur);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEtatMateriel()
	{
		$request = $this->get("/administrations/materiels/etats/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un état matériel");
		$request->assertSee("Nom de l'état");
		$request->assertSee("Couleur de l'état matériel");
		$request->assertSee("Créer l'état matériel");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEtatMaterielIncomplet()
	{
		$request = $this->post("/administrations/materiels/etats", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un état materiel déjà existant
	 */
	public function testTraitementFormulaireCreationEtatMaterielExistant()
	{
		$Etats = factory(EtatMateriel::class, 5)->create();

		$request = $this->post("/administrations/materiels/etats", [
			"_token"  => csrf_token(),
			"nom"     => $Etats->random()->nom,
			"couleur" => $Etats->random()->couleur,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un état matériel à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEtatMaterielComplet()
	{
		$request = $this->post("/administrations/materiels/etats", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"couleur" => "112233",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_materiel", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEtatMateriel()
	{
		$Etat = factory(EtatMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/{$Etat->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Etat->nom}");
		$request->assertSee("Nom de l'état");
		$request->assertSee("Couleur de l'état matériel");
		$request->assertSee("Éditer l'état matériel");
		$request->assertSee("Supprimer l'état matériel");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEtatMaterielIncomplet()
	{
		$Etat = factory(EtatMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/{$Etat->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un EtatMateriel déjà existante
	 */
	public function testTraitementFormulaireEditionEtatMaterielExistant()
	{
		$Etats = factory(EtatMateriel::class, 2)->create();

		$request = $this->put("/administrations/materiels/etats/{$Etats[0]->id}", [
			"_token"  => csrf_token(),
			"nom"     => $Etats[1]->nom,
			"couleur" => "112233",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("etats_materiel", ["nom" => $Etats[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état matériel à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletSansModification()
	{
		$Etat = factory(EtatMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/{$Etat->id}", [
			"_token"  => csrf_token(),
			"nom"     => $Etat->nom,
			"couleur" => $Etat->couleur,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_materiel", ["nom" => $Etat->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état matériel à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletAvecModification()
	{
		$Etat = factory(EtatMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/{$Etat->id}", [
			"_token"  => csrf_token(),
			"nom"     => "unit.testing",
			"couleur" => "556677",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_materiel", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/{$EtatMateriel->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer l'état matériel");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $EtatMateriel->nom . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état matériel à bien été supprimé
	 */
	public function testTraitementSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatMateriel::class)->create();

		$request = $this->delete("/administrations/materiels/etats/{$EtatMateriel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("etats_materiel", [
			"nom"     => $EtatMateriel->nom,
			"couleur" => $EtatMateriel->couleur,
		]);
	}

}
