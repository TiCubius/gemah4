<?php

namespace Tests\Feature\Administrations\Types;

use App\Models\TypeTicket;
use Tests\TestCase;

class TypesTicketsTest extends TestCase
{
	/***
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypeTicket()
	{
		$types = factory(TypeTicket::class, 5)->create();

		$request = $this->get("/administrations/types/tickets");

		$request->assertStatus(200);
		$request->assertSee("Gestion des types de tickets");

		foreach ($types as $type) {
			$request->assertSee($type->libelle);
		}
	}

	/***
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationTypeTicket()
	{
		$request = $this->get("/administrations/types/tickets/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un type de ticket");
		$request->assertSee("Libellé");
		$request->assertSee("Créer");
	}

	/***
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationIncompletTypeTicket()
	{
		$request = $this->post("/administrations/types/tickets", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/***
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un type de ticket déjà existant
	 */
	public function testTraitementFormulaireCreationExistantTypeTicket()
	{
		$types = factory(TypeTicket::class, 5)->create();

		$request = $this->post("/administrations/types/tickets", [
			"_token"  => csrf_token(),
			"libelle" => $types->random()->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/***
	 * Vérifie qu'aucune erreur n'est présente et qu'un type de ticket à bien été créé lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationCompletTypeTicket()
	{
		$request = $this->post("/administrations/types/tickets", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_tickets", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/ticket/created",
            "information" => "Le type de ticket unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/***
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->get("/administrations/types/tickets/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$type->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer ");
	}

	/***
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionIncompletTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->put("/administrations/types/tickets/{$type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/***
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un type de ticket déjà existant
	 */
	public function testTraitementFormulaireEditionExistantTypeTicket()
	{
		$types = factory(TypeTicket::class, 2)->create();

		$request = $this->put("/administrations/types/tickets/{$types[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $types[1]->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_tickets", ["libelle" => $types[0]->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/ticket/modified",
            "information" => "Le type de ticket {$types[1]->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/***
	 * Vérifie qu'aucune erreur n'est présente et que le type de ticket à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionCompletSansModificationTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->put("/administrations/types/tickets/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => $type->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_tickets", ["libelle" => $type->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/ticket/modified",
            "information" => "Le type de ticket {$type->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/***
	 * Vérifie qu'aucune erreur n'est présente et que le type de ticket à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionCompletAvecModificationTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->put("/administrations/types/tickets/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_tickets", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/ticket/modified",
            "information" => "Le type de ticket unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/***
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->get("/administrations/types/tickets/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $type->libelle . "</b>.");
	}

	/***
	 * Vérifie qu'aucune erreur n'est présente et que le type de ticket à bien été supprimé
	 */
	public function testTraitementSuppressionTypeTicket()
	{
		$type = factory(TypeTicket::class)->create();

		$request = $this->delete("/administrations/types/tickets/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("types_tickets", [
			"libelle" => $type->libelle,
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/ticket/deleted",
            "information" => "Le type de ticket {$type->libelle} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}
}