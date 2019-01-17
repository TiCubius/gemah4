<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

		$request->assertSee("Gestion des états matériel");
		$request->assertSee('Gestion des types de tickets');
		$request->assertSee('Gestion des types d\'élève');
		$request->assertSee('Gestion des types d\'établissements');
		$request->assertSee('Historique des actions');
		$request->assertSee('Liste des permissions');
	}
}
