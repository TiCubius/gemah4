<?php

namespace Tests\Feature\Administrations\Materiels;

use App\Models\EtatPhysiqueMateriel;
use Tests\TestCase;

class EtatsPhysiquesMaterielsTest extends TestCase
{
	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEtatMateriels()
	{
		$Etats = factory(EtatPhysiqueMateriel::class, 5)->create();

		$request = $this->get("/administrations/materiels/etats/physiques");

		$request->assertStatus(200);
		$request->assertSee("Gestion des états physiques matériel");

		foreach ($Etats as $Etat) {
			$request->assertSee($Etat->libelle);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEtatMateriel()
	{
		$request = $this->get("/administrations/materiels/etats/physiques/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un état physique matériel");
		$request->assertSee("Libellé");
		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEtatMaterielIncomplet()
	{
		$request = $this->post("/administrations/materiels/etats/physiques", [
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
		$Etats = factory(EtatPhysiqueMateriel::class, 5)->create();

		$request = $this->post("/administrations/materiels/etats/physiques", [
			"_token"  => csrf_token(),
			"libelle" => $Etats->random()->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un état physique matériel à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEtatMaterielComplet()
	{
		$request = $this->post("/administrations/materiels/etats/physiques", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_physiques_materiels", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "etat/physique/materiel/created",
            "information" => "L'état physique matériel unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEtatMateriel()
	{
		$Etat = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/physiques/{$Etat->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Etat->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEtatMaterielIncomplet()
	{
		$Etat = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/physiques/{$Etat->id}", [
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
		$Etats = factory(EtatPhysiqueMateriel::class, 2)->create();

		$request = $this->put("/administrations/materiels/etats/physiques/{$Etats[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $Etats[1]->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("etats_physiques_materiels", ["libelle" => $Etats[0]->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "etat/physique/materiel/modified",
            "information" => "L'état physique matériel {$Etats[1]->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état physique matériel à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletSansModification()
	{
		$Etat = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/physiques/{$Etat->id}", [
			"_token"  => csrf_token(),
			"libelle" => $Etat->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_physiques_materiels", ["libelle" => $Etat->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "etat/physique/materiel/modified",
            "information" => "L'état physique matériel {$Etat->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état physique matériel à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionEtatMaterielCompletAvecModification()
	{
		$Etat = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->put("/administrations/materiels/etats/physiques/{$Etat->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("etats_physiques_materiels", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "etat/physique/materiel/modified",
            "information" => "L'état physique matériel unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->get("/administrations/materiels/etats/physiques/{$EtatMateriel->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $EtatMateriel->libelle . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'état physique matériel à bien été supprimé
	 */
	public function testTraitementSuppressionEtatMateriel()
	{
		$EtatMateriel = factory(EtatPhysiqueMateriel::class)->create();

		$request = $this->delete("/administrations/materiels/etats/physiques/{$EtatMateriel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("etats_physiques_materiels", [
			"libelle" => $EtatMateriel->libelle,
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "etat/physique/materiel/deleted",
            "information" => "L'état physique matériel {$EtatMateriel->libelle} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

}
