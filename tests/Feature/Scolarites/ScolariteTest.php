<?php

namespace Tests\Feature\Scolarites;

use Tests\TestCase;

class ScolariteTest extends TestCase
{
	/**
	 * Test l'index du menu Scolarité
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/scolarites');

		$request->assertStatus(200);
		$request->assertSee("Gestion de la scolarité");

		$request->assertSee("Gestion des élèves");
		$request->assertSee("Gestion des établissements");
		$request->assertSee('Gestion des enseignants');
	}
}
