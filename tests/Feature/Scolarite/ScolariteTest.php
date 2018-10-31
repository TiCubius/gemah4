<?php

namespace Tests\Feature;

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
		$request->assertSee("Gestion de la Scolarité");

		$request->assertSee("Gestion des Élèves");
		$request->assertSee("Gestion des Établissements");
		$request->assertSee('Gestion des Enseignants');
	}
}
