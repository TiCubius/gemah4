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
		$request->assertSee("Statistiques générales");
	}

	/**
	 * Test l'index de l'onglet statistiques générales
	 *
	 * @return void
	 */
	public function testStatistiqueGeneralAffichage()
	{
		$eleves = factory(Eleve::class, 5)->create();

		$request = $this->get('/statistiques/generale');

		$request->assertStatus(200);
		$request->assertSee("Statistiques générales");
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
}

?>