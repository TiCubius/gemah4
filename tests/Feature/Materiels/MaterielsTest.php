<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
