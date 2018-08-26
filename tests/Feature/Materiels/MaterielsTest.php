<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterielsTest extends TestCase
{
	/**
	 * Test l'index du menu du Matériel
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/materiels');

		$request->assertStatus(200);
		$request->assertSee('Gestion du Matériel');
		$request->assertSee('Gestion des Stocks de Matériel');
		$request->assertSee('Gestion des Domaines Matériel');
		$request->assertSee('Gestion des Types Matériel');
	}
}
