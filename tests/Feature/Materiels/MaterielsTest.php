<?php

namespace Tests\Feature\Materiels;

use Tests\TestCase;

class MaterielsTest extends TestCase
{
	/**
	 * Test l'index du menu du matériel
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$request = $this->get('/materiels');

		$request->assertStatus(200);
		$request->assertSee('Gestion du matériel');
		$request->assertSee('Gestion des stocks de matériel');
		$request->assertSee('Gestion des domaines matériel');
		$request->assertSee('Gestion des types matériel');
	}
}
