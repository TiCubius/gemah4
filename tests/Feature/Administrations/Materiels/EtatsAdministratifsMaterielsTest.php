<?php

namespace Tests\Feature;

use App\Models\EtatAdministratifMateriel;
use Tests\TestCase;

class EtatsAdministratifsMaterielsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEtatMateriels()
	{
		$Etats = factory(EtatAdministratifMateriel::class, 5)->create();

		$request = $this->get("/administrations/materiels/etats/administratifs");

		$request->assertStatus(200);
		$request->assertSee("Gestion des états administratifs matériel");

		foreach ($Etats as $Etat) {
			$request->assertSee($Etat->libelle);
			$request->assertSee($Etat->couleur);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEtatMateriel()
	{
		$request = $this->get("/administrations/materiels/etats/administratifs/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un état administratif matériel");
		$request->assertSee("Libellé");
		$request->assertSee("Couleur");
		$request->assertSee("Créer l'état administratif matériel");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEtatMaterielIncomplet()
	{
		$request = $this->post("/administrations/materiels/etats/administratifs", [
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
		$Etats = factory(EtatAdministratifMateriel::class, 5)->create();

		$request = $this->post("/administrations/materiels/etats/administratifs", [
			"_token"  => csrf_token(),
			"libelle" => $Etats->random()->libelle,
			"couleur" => $Etats->random()->couleur,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un état administratif matériel à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEtatMaterielComplet()
	{
		$request = $this->post("/administrations/materiels/etats/administratifs", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
			"couleur" => "112233",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_administratifs_materiels", ["libelle" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEtatMateriel()
	{
		$Etat = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/administratifs/{$Etat->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Etat->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Couleur");
		$request->assertSee("Éditer l'état administratif matériel");
		$request->assertSee("Supprimer l'état administratif matériel");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEtatMaterielIncomplet()
	{
		$Etat = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/administratifs/{$Etat->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un EtatAdministratifMateriel déjà existante
	 */
	public function testTraitementFormulaireEditionEtatMaterielExistant()
	{
		$Etats = factory(EtatAdministratifMateriel::class, 2)->create();

		$request = $this->put("/administrations/materiels/etats/administratifs/{$Etats[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $Etats[1]->libelle,
			"couleur" => "112233",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("etats_administratifs_materiels", ["libelle" => $Etats[0]->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état administratif matériel à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletSansModification()
	{
		$Etat = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/administratifs/{$Etat->id}", [
			"_token"  => csrf_token(),
			"libelle" => $Etat->libelle,
			"couleur" => $Etat->couleur,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_administratifs_materiels", ["libelle" => $Etat->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état administratif matériel à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletAvecModification()
	{
		$Etat = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/administratifs/{$Etat->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
			"couleur" => "556677",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_administratifs_materiels", ["libelle" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/administratifs/{$EtatMateriel->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer l'état administratif matériel");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $EtatMateriel->libelle . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état administratif matériel à bien été supprimé
	 */
	public function testTraitementSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatAdministratifMateriel::class)->create();

		$request = $this->delete("/administrations/materiels/etats/administratifs/{$EtatMateriel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("etats_administratifs_materiels", [
			"libelle" => $EtatMateriel->libelle,
			"couleur" => $EtatMateriel->couleur,
		]);
	}

}
