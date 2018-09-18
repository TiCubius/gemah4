<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministrationsTest extends TestCase
{
	/**
	 * Test l'index du menu de l'Administrations
	 * Il est composé de liens vers les différentes sections utile aux administrateurs
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/administrations');

		$request->assertStatus(200);
		$request->assertSee('Gestion des Utilisateurs');
		$request->assertSee('Gestion des Services');
		$request->assertSee('Liste des Permissions');
		$request->assertSee('Gestion des Tickets');
		$request->assertSee('Historique des Actions');
	}
}
