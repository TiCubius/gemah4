<?php

namespace Tests\Feature\Administrations;

use Tests\TestCase;

class AdministrationsTest extends TestCase
{
	/**
	 * Test l'index du menu de l'administration
	 * Il est composé de liens vers les différentes sections utiles aux administrateurs
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/administrations');

		$request->assertStatus(200);
		$request->assertSee("Gestion des académies");
		$request->assertSee("Gestion des régions");

		$request->assertSee('Gestion des services');
		$request->assertSee('Gestion des utilisateurs');

		$request->assertSee("Gestion des états administratifs matériel");
		$request->assertSee("Gestion des états physiques matériel");
		$request->assertSee('Gestion des types de ticket');
		$request->assertSee('Gestion des types d\'élève');
		$request->assertSee('Gestion des types d\'établissement');
		$request->assertSee('Historique des actions');
	}
}
