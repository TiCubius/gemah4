<?php

namespace Tests\Feature;

use App\Models\Eleve;
use Tests\TestCase;

class StatistiquesTest extends TestCase
{
	/**
	 * Test l'index du menu statistiques
	 * Il est composé de liens vers les différentes sections
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/statistiques');

		$request->assertStatus(200);
		$request->assertSee("Statistiques");
		$request->assertSee("Statistiques élèves");
		$request->assertSee("Statistiques matériels");
		$request->assertSee("Élèves dont la décision est dépassée");
	}

	/**
	 * Test l'affichage des champs de recherche des statistiques élèves
	 *
	 * @return void
	 */
	public function testStatistiqueListeElevesAffichage()
	{
		$request = $this->get('/statistiques/eleves');

		$request->assertStatus(200);
		$request->assertSee("Liste des élèves");
		$request->assertSee("Département");
		$request->assertSee("Type");
		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Etablissement");
		$request->assertSee("Materiels");
		$request->assertSee("Responsable");
		$request->assertSee("Documents");
		$request->assertSee("Ordre");
	}

	/**
	 * Test l'affichage des champs de recherche des statistiques matériels
	 */
	public function testStatistiqueListeMaterielAffichage()
	{
		$request = $this->get('/statistiques/materiels');

		$request->assertStatus(200);
		$request->assertSee("Liste des matériels");
		$request->assertSee("Département");
		$request->assertSee("État administratif");
		$request->assertSee("État physique");
		$request->assertSee("Type de matériel");
		$request->assertSee("Numéro de série");
		$request->assertSee("Clé produit");
		$request->assertSee("Marque");
		$request->assertSee("Modèle");
		$request->assertSee("Nom du fournisseur");
		$request->assertSee("Numéro devis");
		$request->assertSee("Numéro de formulaire chorus");
		$request->assertSee("Numéro de facture chorus");
		$request->assertSee("Numéro d'engagement juridique");
		$request->assertSee("Date d'engagement juridique");
		$request->assertSee("Date de facture");
		$request->assertSee("Date de service fait");
		$request->assertSee("Date de fin de garantie");
		$request->assertSee("Date de prêt");
		$request->assertSee("Acheté pour");
	}

	/**
	 * Test l'affichage des champs de recherche des décisions
	 */
	public function testStatistiqueListeDecisionslAffichage()
	{
		$request = $this->get('/statistiques/decisions');

		$request->assertStatus(200);
		$request->assertSee("Liste des élèves dont la décision a expiré depuis le");
	}
}

?>