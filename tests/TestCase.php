<?php

namespace Tests;

use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;
	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();

		// La plupart des tests seront effectués sans se soucier des permissions
		// Il est donc nécessaire de :
		// - Obtenir toutes les permissions
		// - Générer un service possédant toutes les permissions
		// - Générer un utilisateur possédant ce service

		$this->seed(\PermissionsSeeder::class);
		$service = factory(Service::class)->create();

		foreach (Permission::all() as $permission) {
			$service->permissions()->attach($permission);
		}

		$user = factory(Utilisateur::class)->create([
			"service_id" => $service->id,
		]);

		$this->session(["user" => $user]);
	}
}
