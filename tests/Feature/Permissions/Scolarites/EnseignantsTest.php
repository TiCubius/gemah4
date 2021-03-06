<?php

namespace Tests\Feature\Permissions;

use App\Models\Academie;
use App\Models\Decision;
use App\Models\Departement;
use App\Models\Document;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\EtatAdministratifMateriel;
use App\Models\EtatPhysiqueMateriel;
use App\Models\Materiel;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TypeDocument;
use App\Models\TypeDecision;
use App\Models\TypeEtablissement;
use App\Models\TypeMateriel;
use App\Models\TypeTicket;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EnseignantsTest extends TestCase
{
	private $service;
	protected $user;

	/**
	 * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des enseignants
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

        $permissions = Permission::where("id", "LIKE", "enseignants/%")->get();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}

	/**
	 * Vérifie que toutes les routes de la gestion des enseignants soient fonctionnelles
	 */
	public function testAccessAutorise()
	{
		$enseignant = factory(Enseignant::class)->create();


		$getRoutes = [
			"/scolarites/enseignants",
			"/scolarites/enseignants/create",
            "/scolarites/enseignants/{$enseignant->id}",
			"/scolarites/enseignants/{$enseignant->id}/edit",
		];

		$postRoutes = [
			"/scolarites/enseignants",
		];

		$patchRoutes = [
			"/scolarites/enseignants/{$enseignant->id}",
		];

		$deleteRoutes = [
			"/scolarites/enseignants/{$enseignant->id}",
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
