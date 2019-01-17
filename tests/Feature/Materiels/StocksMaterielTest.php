<?php

namespace Tests\Feature;

use App\Models\Departement;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\Materiel;
use App\Models\TypeMateriel;
use Tests\TestCase;

class StocksMaterielTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexStocks()
	{
		$Stocks = factory(Materiel::class, 5)->create();

		$request = $this->get("/materiels/stocks");

		$request->assertStatus(200);
		$request->assertSee("Gestion des stocks matériel");

		foreach ($Stocks as $Stock) {
			$request->assertSee($Stock->modele);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationStock()
	{
		$request = $this->get("/materiels/stocks/create");

		$request->assertStatus(200);

		$request->assertSee("Création d'un matériel");
		$request->assertSee("Type");
		$request->assertSee("Marque");
		$request->assertSee("Modèle");
		$request->assertSee("Numéro de série / Clé de produit");
		$request->assertSee("Nom du fournisseur");
		$request->assertSee("Prix TTC (€)");
		$request->assertSee("Etat");
		$request->assertSee("Informations Administrative");

		$request->assertSee("Numéro de devis");
		$request->assertSee("Numéro de formulaire CHORUS");
		$request->assertSee("Nom de facture CHROUS");
		$request->assertSee("Numéro d'engagement juridique");
		$request->assertSee("Date d'engagement juridique");
		$request->assertSee("Date de la facture");
		$request->assertSee("Date de service fait");
		$request->assertSee("Date de fin de garantie");
		$request->assertSee("Acheté pour");
		$request->assertSee("Département");

		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationStockIncomplet()
	{
		$request = $this->post("/materiels/stocks", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un matériel déjà existant
	 */
	public function testTraitementFormulaireCreationStockExistant()
	{
		// NOTE: Lors de l'écrite du test, la manière d'identifier de manière unique un Matériel
		// n'est pas définie. Le test n'est donc pas possible.

		$this->assertTrue(true);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un matériel à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationStockComplet()
	{
	    $departement = factory(Departement::class)->create();
		$DomaineMateriel = factory(DomaineMateriel::class)->create();
		$TypeMateriel = factory(TypeMateriel::class)->create([
			"domaine_id" => $DomaineMateriel->id,
		]);

		$request = $this->post("/materiels/stocks", [
			"_token"   => csrf_token(),
			"type_id"  => $TypeMateriel->id,
			"marque"   => "unit.testing",
			"modele"   => "unit.testing",
			"prix_ttc" => 5.99,
			"etat_id"  => 1,
            "departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("materiels", ["marque" => "unit.testing"]);
	}

    /**
     * Vérifie que les données af
     */
	public function testAffichageInformationsStock()
	{
		$stock = factory(Materiel::class)->create();

		$request = $this->get("/materiels/stocks/{$stock->id}");

		$request->assertStatus(200);

		$request->assertSee("Descriptif matériel de {$stock->modele}");
		$request->assertSee($stock->type->nom);
		$request->assertSee($stock->marque);
		$request->assertSee($stock->modele);
		$request->assertSee($stock->num_serie);
		$request->assertSee($stock->nom_fournisseur);
		$request->assertSee($stock->prix_ttc);
		$request->assertSee($stock->etat->nom);
		$request->assertSee("Informations Administrative");

		$request->assertSee("N° de devis");
		$request->assertSee("N° de formulaire CHORUS");
		$request->assertSee("N° d'engagement juridique");
		$request->assertSee("N° de facture CHORUS");
		$request->assertSee("Date d'engagement juridique");
		$request->assertSee("Date de facture");
		$request->assertSee("Date de service fait");
		$request->assertSee("Date de fin de garantie");
		$request->assertSee("Acheté pour");
		$request->assertSee("Modifier le matériel");
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionStock()
	{
		$Stock = factory(Materiel::class)->create();

		$request = $this->get("/materiels/stocks/{$Stock->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$Stock->modele}");
		$request->assertSee("Type");
		$request->assertSee("Marque");
		$request->assertSee("Modèle");
		$request->assertSee("Numéro de série / Clé de produit");
		$request->assertSee("Nom du fournisseur");
		$request->assertSee("Prix TTC (€)");
		$request->assertSee("Etat");
		$request->assertSee("Informations Administrative");

		$request->assertSee("Numéro de devis");
		$request->assertSee("Numéro de formulaire CHORUS");
		$request->assertSee("Nom de facture CHROUS");
		$request->assertSee("Numéro d'engagement juridique");
		$request->assertSee("Date d'engagement juridique");
		$request->assertSee("Date de la facture");
		$request->assertSee("Date de service fait");
		$request->assertSee("Date de fin de garantie");
		$request->assertSee("Acheté pour");
		$request->assertSee("Département");

		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionStockIncomplet()
	{
		$Stock = factory(Materiel::class)->create();

		$request = $this->put("/materiels/stocks/{$Stock->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Matériel déjà existant
	 */
	public function testTraitementFormulaireEditionStockExistant()
	{
		// NOTE: Lors de l'écrite du test, la manière d'identifier de manière unique un Matériel
		// n'est pas définie. Le test n'est donc pas possible.

		$this->assertTrue(true);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Matériel à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionStockCompletSansModification()
	{
	    $departement = factory(Departement::class)->create();
		$Stock = factory(Materiel::class)->create();
		$DomaineMateriel = factory(DomaineMateriel::class)->create();
		$TypeMateriel = factory(TypeMateriel::class)->create([
			"domaine_id" => $DomaineMateriel->id,
		]);

		$request = $this->put("/materiels/stocks/{$Stock->id}", [
			"_token"   => csrf_token(),
			"type_id"  => $TypeMateriel->id,
			"marque"   => $Stock->marque,
			"modele"   => $Stock->modele,
			"prix_ttc" => $Stock->prix_ttc,
			"etat_id"  => $Stock->etat_id,
            "departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("materiels", ["modele" => $Stock->modele]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Matériel à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionStockCompletAvecModification()
	{
	    $departement = factory(Departement::class)->create();
		$Stock = factory(Materiel::class)->create();
		$DomaineMateriel = factory(DomaineMateriel::class)->create();
		$TypeMateriel = factory(TypeMateriel::class)->create([
			"domaine_id" => $DomaineMateriel->id,
		]);

		$request = $this->put("/materiels/stocks/{$Stock->id}", [
			"_token"     => csrf_token(),
			"domaine_id" => $DomaineMateriel->id,
			"type_id"    => $TypeMateriel->id,
			"marque"     => "unit.testing",
			"modele"     => "unit.testing",
			"prix_ttc"   => 5.99,
			"etat_id"    => 1,
            "departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("materiels", ["modele" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionStock()
	{
		$Stock = factory(Materiel::class)->create();

		$request = $this->get("/materiels/stocks/{$Stock->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le matériel");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$Stock->marque} {$Stock->modele}" . "</b>.");
	}

	/**
	 * Vérifie que des erreurs sont présentes et que le Stock n'à pas été supprimé s'il est associé à un Eleve
	 */
	public function testTraitementSuppressionStockAssocie()
	{
		$eleve = factory(Eleve::class)->create();
		$stock = factory(Materiel::class)->create();
		$stock->eleve()->associate($eleve)->save();

		$request = $this->delete("/materiels/stocks/{$stock->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("materiels", ["modele" => $stock->modele, "marque" => $stock->marque]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Stock à bien été supprimé s'il n'est associé à aucun
	 * Eleve
	 */
	public function testTraitementSuppressionStockNonAssocie()
	{
		$stock = factory(Materiel::class)->create();

		$request = $this->delete("/materiels/stocks/{$stock->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("materiels", ["modele" => $stock->modele, "marque" => $stock->marque]);
	}

}
