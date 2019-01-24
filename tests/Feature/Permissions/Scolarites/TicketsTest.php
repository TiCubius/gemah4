<?php

namespace Tests\Feature\Permissions;

use App\Models\Eleve;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TicketsTest extends TestCase
{
	private $service;
	private $user;

	/**
	 * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des tickets
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

        $permissions = Permission::where("id", "LIKE", "eleves/tickets/%")->get();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}

	/**
	 * Vérifie que toutes les routes de la gestion des tickets soient fonctionnelles
	 */
	public function testAccessAutorise()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			'eleve_id' => $eleve->id,
		]);


		$getRoutes = [
			"/scolarites/eleves/{$eleve->id}/tickets",
			"/scolarites/eleves/{$eleve->id}/tickets/create",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/edit",
		];

		$postRoutes = [
			"/scolarites/eleves/{$eleve->id}/tickets",
		];

		$patchRoutes = [
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",

		];

		$deleteRoutes = [
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",
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
