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

class AllPermissionsTest extends TestCase
{
	private $service;
	protected $user;

	/**
	 * Création d'un utilisateur possèdant un service sans permissions
	 * et simulation de la connexion.
	 */
	public function setUp()
	{
		parent::setUp();

		$permissions = Permission::all();

		$this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

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

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
		}

		foreach ($postRoutes as $route => $data) {
			$request = $this->post($route, $data);

			// Vérification de la présence de l'erreur dans la session
			if (session("errors")) {
				$this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
			}
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
		$etatAdministratifMateriel = factory(EtatAdministratifMateriel::class)->create();
		$etatPhysiqueMateriel = factory(EtatPhysiqueMateriel::class)->create();
		$materiel = factory(Materiel::class)->create();
		$responsable = factory(Responsable::class)->create();
		$region = factory(Region::class)->create();
		$service = factory(Service::class)->create();
        $utilisateur = factory(Utilisateur::class)->create();
		$type = factory(TypeMateriel::class)->create();
		$typeDecision = factory(TypeDecision::class)->create();
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
			"/scolarites/eleves/{$eleve->id}/affectations/responsables/create",
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
			// "/administrations/departements/{$departement->id}", // ERROR 404
			"/administrations/departements/{$departement->id}/edit",
			"/administrations/academies",
			"/administrations/academies/create",
			// "/administrations/academies/{$academie->id}", // ERROR 404
			"/administrations/academies/{$academie->id}/edit",
			"/administrations/regions",
			"/administrations/regions/create",
			// "/administrations/regions/{$region->id}", // ERROR 404
			"/administrations/regions/{$region->id}/edit",
			"/administrations/services",
			"/administrations/services/create",
			// "/administrations/services/{$service->id}", // ERROR 404
			"/administrations/services/{$service->id}/edit",
            "/administrations/utilisateurs",
            "/administrations/utilisateurs/create",
            // "/administrations/utilisateurs/{$utilisateur->id}", // ERROR 404
            "/administrations/utilisateurs/{$utilisateur->id}/edit",
			"/administrations/types/documents",
			"/administrations/types/documents/create",
			// "/administrations/types/documents/{$typeDocument->id}", // ERROR 404
			"/administrations/types/documents/{$typeDocument->id}/edit",
			"/administrations/types/decisions",
			"/administrations/types/decisions/create",
			// "/administrations/types/decisions/{$typeDecision->id}", // ERROR 404
			"/administrations/types/decisions/{$typeDecision->id}/edit",
			"/administrations/types/etablissements",
			"/administrations/types/etablissements/create",
			// "/administrations/types/etablissements/$typeEtablissement->id}", // ERROR 404
			"/administrations/types/etablissements/{$typeEtablissement->id}/edit",
			"/administrations/types/tickets",
			"/administrations/types/tickets/create",
			// "/administrations/types/tickets/{$typeTicket->id}", // ERROR 404
			"/administrations/types/tickets/{$typeTicket->id}/edit",
			"/administrations/materiels/etats/administratifs",
			"/administrations/materiels/etats/administratifs/create",
			// "/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}", // ERROR 404
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}/edit",
			"/administrations/materiels/etats/physiques",
			"/administrations/materiels/etats/physiques/create",
			// "/administrations/materiels/etats/physiques/{$etatAdministratifMateriel->id}", // ERROR 404
			"/administrations/materiels/etats/physiques/{$etatPhysiqueMateriel->id}/edit",

            "/statistiques",
            "/statistiques/generale",
		];

		$postRoutes = [
			"/scolarites/eleves/{$eleve->id}/affectations/responsables",
            "/scolarites/eleves",
			"/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}",
			"/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}",
			"/scolarites/eleves/{$eleve->id}/documents",
			"/scolarites/eleves/{$eleve->id}/documents/decisions",
            "/scolarites/eleves/{$eleve->id}/tickets",
            "/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages",
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
            "/administrations/utilisateurs",
			"/administrations/types/documents",
			"/administrations/types/decisions",
			"/administrations/types/etablissements",
			"/administrations/types/tickets",
			"/administrations/materiels/etats/administratifs",
			"/administrations/materiels/etats/physiques",
		];

		$patchRoutes = [
			"/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}",
            "/scolarites/eleves/{$eleve->id}",
			"/scolarites/eleves/{$eleve->id}/documents/{$documents[0]->id}",
			"/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}",
            "/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}",
            "/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}",
			"/scolarites/etablissements/{$etablissement->id}",
			"/scolarites/enseignants/{$enseignant->id}",

			"/responsables/{$responsable->id}",

			"/materiels/stocks/{$materiel->id}",
			"/materiels/domaines/{$domaine->id}",
			"/materiels/types/{$type->id}",

			"/conventions",

			"/administrations/parametres",
			"/administrations/departements/{$departement->id}",
			"/administrations/academies/{$academie->id}",
			"/administrations/regions/{$region->id}",
			"/administrations/services/{$service->id}",
            "/administrations/utilisateurs/{$utilisateur->id}",
			"/administrations/types/documents/{$typeDocument->id}",
			"/administrations/types/decisions/{$typeDecision->id}",
			"/administrations/types/etablissements/{$typeEtablissement->id}",
			"/administrations/types/tickets/{$typeTicket->id}",
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}",
			"/administrations/materiels/etats/physiques/{$etatPhysiqueMateriel->id}",
		];

		$deleteRoutes = [
            "/scolarites/eleves/{$eleve->id}",
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
            "/administrations/utilisateurs/{$utilisateur->id}",
			"/administrations/types/documents/{$typeDocument->id}",
			"/administrations/types/decisions/{$typeDecision->id}",
			"/administrations/types/etablissements/{$typeEtablissement->id}",
			"/administrations/types/tickets/{$typeTicket->id}",
			"/administrations/materiels/etats/administratifs/{$etatAdministratifMateriel->id}",
			"/administrations/materiels/etats/physiques/{$etatPhysiqueMateriel->id}",
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
