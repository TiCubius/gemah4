<?php

namespace Tests\Feature\Scolarites;

use App\Models\Eleve;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Tests\TestCase;

class TicketMessagesTest extends TestCase
{
	private $formInputs = [
		'contenu',
	];

	/**
	 * Vérifie qu'il est possible d'ajouter un message
	 */
	public function testAjoutMessageTicket()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->post("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages", [
			"_token"  => csrf_token(),
			"contenu" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("messages_tickets", ["contenu" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "ticket/message/created",
            "contenue" => "Le ticket {$ticket->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie que le formulaire contient toutes les données nécessaires
	 */
	public function testFormulaireCreationMessage()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}");

		$request->assertStatus(200);
		$request->assertSee("Nouveau message");
	}

	/**
	 * Vérifie que le formulaire contient toutes les données nécessaires
	 */
	public function testFormulaireEditionMessage()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);
		$message = factory(TicketMessage::class)->create([
			"ticket_id" => $ticket->id,
		]);

		$request = $this->get("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Contenu");
	}

	/**
	 * Vérifie que le message est bien modifié
	 */
	public function testTraitementFormulaireEditionMessage()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);
		$message = factory(TicketMessage::class)->create([
			"ticket_id" => $ticket->id,
		]);

		$request = $this->patch("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}", [
			'_token'  => csrf_token(),
			'contenu' => 'unit.testing',
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("messages_tickets", ["contenu" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "ticket/message/modified",
            "contenue" => "Le ticket {$ticket->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'un message peut être supprimé
	 */
	public function testSuppressionMessage()
	{
		$eleve = factory(Eleve::class)->create();
		$ticket = factory(Ticket::class)->create([
			"eleve_id" => $eleve->id,
		]);
		$message = factory(TicketMessage::class)->create([
			"ticket_id" => $ticket->id,
		]);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/tickets/{$ticket->id}/messages/{$message->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("messages_tickets", ["contenu" => $message->contenu]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "ticket/message/deleted",
            "contenue" => "Le ticket {$ticket->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}
}