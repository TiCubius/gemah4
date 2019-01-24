<?php

namespace Tests\Feature\Permissions;

use App\Models\DomaineMateriel;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DomainesMaterielTest extends TestCase
{
	private $service;
	private $user;

	/**
	 * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des domaines matériels
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

        $permissions = Permission::where("id", "LIKE", "materiels/domaines/%")->get();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}

	/**
	 * Vérifie que toutes les routes de la gestion des domaines matériels soient fonctionnelles
	 */
	public function testAccessAutorise()
	{
		$domaine = factory(DomaineMateriel::class)->create();


		$getRoutes = [
			"/materiels/domaines",
			"/materiels/domaines/create",
			"/materiels/domaines/{$domaine->id}",
			"/materiels/domaines/{$domaine->id}/edit",
		];

		$postRoutes = [
			"/materiels/domaines",
		];

		$patchRoutes = [
			"/materiels/domaines/{$domaine->id}",
		];

		$deleteRoutes = [
			"/materiels/domaines/{$domaine->id}",
		];


		foreach ($getRoutes as $route) {
			$request = $this->get($route);

			// Vérification de la redirection
			$request->assertStatus(200);

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
		}

		foreach ($postRoutes as $route) {
			$request = $this->post($route);

			// Vérification de la redirection
			$request->assertStatus(302);

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
		}

		foreach ($patchRoutes as $route) {
			$request = $this->patch($route);

			// Vérification de la redirection
			$request->assertStatus(302);

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
		}

		foreach ($deleteRoutes as $route) {
			$request = $this->delete($route);

			// Vérification de la redirection
			$request->assertStatus(302);

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
		}
	}
}
