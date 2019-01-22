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
use App\Models\EtatMateriel;
use App\Models\Materiel;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TypeDocument;
use App\Models\TypeEleve;
use App\Models\TypeEtablissement;
use App\Models\TypeMateriel;
use App\Models\TypeTicket;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AllPermissionsTest extends TestCase
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

		$permissions = Permission::all();

		$this->service = factory(Service::class)->create();
		foreach ($permissions as $permission) {
			$this->service->permissions()->attach($permission);
		}

		$this->user = factory(Utilisateur::class)->create([
			"service_id" => $this->service->id,
			"password"   => Hash::make("root"),
		]);

		$this->session(["user" => $this->user]);
	}

	/**
	 * Vérifie que les routes de base de GEMAH fonctionnent
	 */
	public function testGemah()
	{
		$getRoutes = [
			"/",
			"/connexion",
			"/deconnexion",
		];

		$postRoutes = [
			"/connexion" => ["email" => $this->user->email, "password" => "root"],
		];

		foreach ($getRoutes as $route) {
			$request = $this->get($route);

			$request->assertSessionHasNoErrors();
		}

		foreach ($postRoutes as $route => $data) {
			$request = $this->post($route, $data);

			$request->assertSessionHasNoErrors();
		}
	}

	/**
	 * Vérifie que toutes les autres routes soient refusées
	 */
	public function testAccessAutorise()
	{
		$academie = factory(Academie::class)->create();
		$domaine = factory(DomaineMateriel::class)->create();
		$departement = factory(Departement::class)->create();
		$eleve = factory(Eleve::class)->create();
		$enseignant = factory(Enseignant::class)->create();
		$etablissement = factory(Etablissement::class)->create();
		$etatMateriel = factory(EtatMateriel::class)->create();
		$materiel = factory(Materiel::class)->create();
		$responsable = factory(Responsable::class)->create();
		$region = factory(Region::class)->create();
		$service = factory(Service::class)->create();
		$type = factory(TypeMateriel::class)->create();
		$typeEleve = factory(TypeEleve::class)->create();
		$typeEtablissement = factory(TypeEtablissement::class)->create();
		$typeTicket = factory(TypeTicket::class)->create();
		$typeDocument = factory(TypeDocument::class)->create();

		$documents = factory(Document::class, 2)->create([
			'eleve_id' => $eleve->id,
		]);
		$decision = factory(Decision::class)->create([
			'document_id' => $documents[1]->id,
		]);
		$ticket = factory(Ticket::class)->create([
			'eleve_id' => $eleve->id,
		]);
		$message = factory(TicketMessage::class)->create([
			'ticket_id' => $ticket->id,
		]);


		$eleve->documents()->save($documents[0]);
		$eleve->etablissement()->associate($etablissement);
		$eleve->materiels()->save($materiel);
		$eleve->responsables()->save($responsable);

		$getRoutes = [
			"/scolarites",
			"/scolarites/eleves",
			"/scolarites/eleves/create",
			"/scolarites/eleves/{$eleve->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/etablissements",
			"/scolarites/eleves/{$eleve->id}/affectations/materiels",
			"/scolarites/eleves/{$eleve->id}/affectations/responsables",
			"/scolarites/eleves/{$eleve->id}/edit",
			// "/scolarites/eleves/{$eleve->id}/impressions/autorisations", // libpng warning: iCCP: known incorrect sRGB profil
			// "/scolarites/eleves/{$eleve->id}/impressions/consignes",     // libpng warning: iCCP: known incorrect sRGB profil
			// "/scolarites/eleves/{$eleve->id}/impressions/conventions",   // libpng warning: iCCP: known incorrect sRGB profil
			// "/scolarites/eleves/{$eleve->id}/impressions/recapitulatifs",// libpng warning: iCCP: known incorrect sRGB profil
			// "/scolarites/eleves/{$eleve->id}/impressions/recuperations", // libpng warning: iCCP: known incorrect sRGB profil
			"/scolarites/eleves/{$eleve->id}/documents",
			"/scolarites/eleves/{$eleve->id}/documents/create",
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}/edit",
			// "/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}/download", // ERROR 500: Le fichier n'existe pas.
			"/scolarites/eleves/{$eleve->id}/documents/decisions/create",
			"/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}/edit",
			// "/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}/download", // ERROR 500: Le fichier n'existe pas.
			"/scolarites/eleves/{$eleve->id}/tickets",
			"/scolarites/eleves/{$eleve->id}/tickets/create",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/edit",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}/edit",
			"/scolarites/etablissements",
			"/scolarites/etablissements/create",
			"/scolarites/etablissements/{$etablissement->id}/edit",
			"/scolarites/enseignants",
			"/scolarites/enseignants/create",
			"/scolarites/enseignants/{$enseignant->id}/edit",

			"/responsables",
			"/responsables/create",
			// "/responsables/{$responsable->id}", // ERROR 404
			"/responsables/{$responsable->id}/edit",

			"/materiels",
			"/materiels/stocks",
			"/materiels/stocks/create",
			"/materiels/stocks/{$materiel->id}",
			"/materiels/stocks/{$materiel->id}/edit",
			"/materiels/domaines",
			"/materiels/domaines/create",
			"/materiels/domaines/{$domaine->id}",
			"/materiels/domaines/{$domaine->id}/edit",
			"/materiels/types",
			"/materiels/types/create",
			"/materiels/types/{$type->id}",
			"/materiels/types/{$type->id}/edit",

			"/conventions",

			"/administrations",
			"/administrations/departements",
			"/administrations/departements/create",
			"/administrations/departements/{$departement->id}",
			"/administrations/departements/{$departement->id}/edit",
			"/administrations/academies",
			"/administrations/academies/create",
			"/administrations/academies/{$academie->id}",
			"/administrations/academies/{$academie->id}/edit",
			"/administrations/regions",
			"/administrations/regions/create",
			"/administrations/regions/{$region->id}",
			"/administrations/regions/{$responsable->id}/edit",
			"/administrations/services",
			"/administrations/services/create",
			// "/administrations/services/{$service->id}", // ERROR 404
			"/administrations/services/{$service->id}/edit",
			"/administrations/eleves/types",
			"/administrations/eleves/types/create",
			// "/administrations/eleves/types/{$typeEleve->id}", // ERROR 404
			"/administrations/eleves/types/{$typeEleve->id}/edit",
			"/administrations/etablissements/types",
			"/administrations/etablissements/types/create",
			// "/administrations/etablissements/types/{$typeEtablissement->id}", // ERROR 404
			"/administrations/etablissements/types/{$typeEtablissement->id}/edit",
			"/administrations/types/tickets",
			"/administrations/types/tickets/create",
			// "/administrations/types/tickets/{$typeTicket->id}", // ERROR 404
			"/administrations/types/tickets/{$typeTicket->id}/edit",
			"/administrations/materiels/etats",
			"/administrations/materiels/etats/create",
			// "/administrations/materiels/etats/{$etatMateriel->id}", // ERROR 404
			"/administrations/materiels/etats/{$etatMateriel->id}/edit",
		];

		$postRoutes = [
			"/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}",
			"/scolarites/eleves/{$eleve->id}/documents",
			"/scolarites/eleves/{$eleve->id}/documents/decisions",
			"/scolarites/etablissements",
			"/scolarites/enseignants",

			"/responsables",

			"/materiels/stocks",
			"/materiels/domaines",
			"/materiels/types",

			"/administrations/departements",
			"/administrations/academies",
			"/administrations/regions",
			"/administrations/services",
			"/administrations/eleves/types",
			"/administrations/etablissements/types",
			"/administrations/types/tickets",
			"/administrations/materiels/etats",
		];

		$patchRoutes = [
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}",
			"/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}",
			"/scolarites/etablissements/{$etablissement->id}",
			"/scolarites/enseignants/{$enseignant->id}",

			"/responsables/{$responsable->id}",

			"/materiels/stocks/{$materiel->id}",
			"/materiels/domaines/{$domaine->id}",
			"/materiels/types/{$type->id}",

			"/conventions",

			"/administrations/departements/{$departement->id}",
			"/administrations/academies/{$academie->id}",
			"/administrations/regions/{$region->id}",
			"/administrations/services/{$service->id}",
			"/administrations/eleves/types/{$typeEleve->id}",
			"/administrations/etablissements/types/{$typeEtablissement->id}",
			"/administrations/types/tickets/{$typeTicket->id}",
			"/administrations/materiels/etats/{$etatMateriel->id}",
		];

		$deleteRoutes = [
			"/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}",
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}",
			"/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}",
			"/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",
			"/scolarites/etablissements/{$etablissement->id}",
			"/scolarites/enseignants/{$enseignant->id}",

			"/responsables/{$responsable->id}",

			"/materiels/stocks/{$materiel->id}",
			"/materiels/domaines/{$domaine->id}",
			"/materiels/types/{$type->id}",

			"/administrations/departements/{$departement->id}",
			"/administrations/academies/{$academie->id}",
			"/administrations/regions/{$region->id}",
			"/administrations/services/{$service->id}",
			"/administrations/eleves/types/{$typeEleve->id}",
			"/administrations/etablissements/types/{$typeEtablissement->id}",
			"/administrations/types/tickets/{$typeTicket->id}",
			"/administrations/materiels/etats/{$etatMateriel->id}",
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
