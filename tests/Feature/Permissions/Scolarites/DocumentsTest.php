<?php

namespace Tests\Feature\Permissions;

use App\Models\Document;
use App\Models\Eleve;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DocumentsTest extends TestCase
{
	private $service;
	private $user;

	/**
	 * Création d'un utilisateur possèdant un service sans permissions
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

        $permissions = Permission::where("id", "LIKE", "eleves/documents/%")->get();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}

	/**
	 * Vérifie que toutes les autres routes soient refusées
	 */
	public function testAccessAutorise()
	{
		$eleve = factory(Eleve::class)->create();

		$documents = factory(Document::class, 2)->create([
			'eleve_id' => $eleve->id,
		]);


		$eleve->documents()->save($documents[0]);


		$getRoutes = [
			"/scolarites/eleves/{$eleve->id}/documents",
			"/scolarites/eleves/{$eleve->id}/documents/create",
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}/edit",
			// "/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}/download", // ERROR 500: Le fichier n'existe pas.
		];

		$postRoutes = [
			"/scolarites/eleves/{$eleve->id}/documents",
		];

		$patchRoutes = [
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}",
		];

		$deleteRoutes = [
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}",
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
