<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
	/**
	 * Test l'index de l'application
	 * Il est composé de liens vers les diverses sections de l'application
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/');

		$request->assertStatus(200);
		$request->assertSee('Gestion des Elèves');
		$request->assertSee('Gestion des Responsables');
		$request->assertSee('Gestion du Matériel');
		$request->assertSee('Statistiques');
		$request->assertSee('Administrations');
	}

}
