<?php

namespace Tests\Feature;

use Tests\TestCase;

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
		$request->assertSee('Gestion de la scolarité');
		$request->assertSee('Gestion des responsables');
		$request->assertSee('Gestion du matériel');
		$request->assertSee("Conventions");
		$request->assertSee('Statistiques');
		$request->assertSee('Administrations');
	}

}
