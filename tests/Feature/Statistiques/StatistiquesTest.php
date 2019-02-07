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
		$request->assertSee("Liste élèves");
        $request->assertSee("Liste matériels");
	}

	/**
	 * Test l'index de l'onglet statistiques générales
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
		$request->assertSee("Date de naissance");
		$request->assertSee("Action");
	}

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
}

?>