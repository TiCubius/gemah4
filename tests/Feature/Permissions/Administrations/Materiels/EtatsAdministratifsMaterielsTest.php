<?php

namespace Tests\Feature\Permissions;

use App\Models\EtatAdministratifMateriel;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EtatsAdministratifsMaterielsTest extends TestCase
{
	private $service;
	protected $user;

	/**
	 * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des états matériel administratifs
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

		$permissions = Permission::where("id", "LIKE", "administrations/etats/materiels/administratifs/%")->get();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}


	/**
	 * Vérifie que toutes les routes de la gestion des états matériel soient fonctionnelles
	 */
	public function testAccessAutorise()
	{
		$etatAdministratifMateriel = factory(EtatAdministratifMateriel::class)->create();

		$getRoutes = [
			"/administrations/materiels/etats/administratifs",
			"/administrations/materiels/etats/administratifs/create",
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}",
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}/edit",
		];

		$postRoutes = [
            "/administrations/materiels/etats/administratifs",
		];

		$patchRoutes = [
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}",
		];

		$deleteRoutes = [
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}",
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
