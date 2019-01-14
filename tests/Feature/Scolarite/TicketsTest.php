<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TypeTicket;
use Carbon\Carbon;
use Tests\TestCase;

class TicketsTest extends TestCase
{
	/**
	 * Liste des forms
	 *
	 * @var array
	 */
	private $formInputs = [
		"Type",
		"Libellé",
	];

	/**
	 * Vérifie que l'index affiche bien tout les tickets pour l'élève
	 */
	public function testAffichageIndex()
	{
		$eleve = factory(Eleve::class)->create();
		$tickets = factory(Ticket::class, 5)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets");

		$request->assertStatus(200);
		$request->assertSee("Gestion des tickets");

		foreach ($tickets as $ticket) {
			$request->assertSee($ticket->libelle);
			$request->assertSee($ticket->description);
			$request->assertSee($ticket->type->libelle);
			$request->assertSee(Carbon::parse($ticket->created_at)
				->format("d/m/Y H:m:s"));
		}
	}

	/**
	 * Vérifie que le formulaire de création demande toutes les données nécessaires
	 */
	public function testAffichageFormulaireCreationTicket()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un ticket");

		foreach ($this->formInputs as $input) {
			$request->assertSee($input);
		}
	}

	/**
	 * Vérifie que des erreurs apparaissent lorsque le formulaire est incomplet
	 */
	public function testTraitementFormulaireCreationTicketIncomplet()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->post("/scolarites/eleves/{$eleve->id}/tickets", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que le ticket est bien créé lorsque le formulaire est complet
	 */
	public function testTraitementFormulaireCreationTicketComplet()
	{
		$eleve = factory(Eleve::class)->create();
		$typeTicket = factory(TypeTicket::class)->create();

		$request = $this->post("/scolarites/eleves/{$eleve->id}/tickets", [
			"_token"         => csrf_token(),
			"libelle"        => "unit.testing",
			"type_ticket_id" => $typeTicket->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("tickets", [
			"eleve_id"       => $eleve->id,
			"type_ticket_id" => $typeTicket->id,
		]);
	}

	public function testAffichageTicket()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);
		$messages = factory(TicketMessage::class, 5)->create([
			"ticket_id" => $ticket->id,
		]);

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}");

		$request->assertStatus(200);
		$request->assertSee($ticket->libelle);
		foreach ($messages as $message) {
			$request->assertSee($message->contenu);
		}
	}

	/**
	 * Vérifie que le formulaire d'édition demande toutes les données nécessaires
	 */
	public function testAffichageFormulaireEditionTicket()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition d'un ticket");

		foreach ($this->formInputs as $input) {
			$request->assertSee($input);
		}
	}

	/**
	 * Vérifie que des erreurs apparaissent lorsque le formulaire est incomplet
	 */
	public function testTraitementFormulaireEditionIncomplet()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->patch("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune errreur n'apparait lorsque le formulaire est complet
	 */
	public function testTraitementFormulaireEditionComplet()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);
		$typeTicket = factory(TypeTicket::class)->create();


		$request = $this->patch("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}", [
			"_token"         => csrf_token(),
			"libelle"        => "unit.testing",
			"type_ticket_id" => $typeTicket->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("tickets", [
			"eleve_id"       => $eleve->id,
			"id"             => $ticket->id,
			"type_ticket_id" => $typeTicket->id,
		]);
	}

	/**
	 * Vérifie qu'un moyen de supprimer le ticket existe
	 */
	public function testAffichageAlerteSuppressionTicket()
	{
		$ticketMessage = factory(TicketMessage::class)->create();

		$request = $this->get("/scolarites/eleves/{$ticketMessage->ticket->eleve->id}/tickets/{$ticketMessage->ticket->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer le ticket");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . str_limit($ticketMessage->ticket->libelle, 15) . "</b>.");
	}

	/**
	 * Vérifie que la suppression d'un ticket fonctionne et supprime tout les messages associés
	 */
	public function testSuppressionTicket()
	{
		$ticketMessage = factory(TicketMessage::class)->create();

		$request = $this->delete("/scolarites/eleves/{$ticketMessage->ticket->eleve->id}/tickets/{$ticketMessage->ticket->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("tickets", ["id" => $ticketMessage->ticket->id]);
		$this->assertDatabaseMissing("ticket_messages", ["id" => $ticketMessage->id]);
	}
}