<?php

namespace Tests\Feature;

use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\TypeDocument;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class DecisionsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexDecision()
	{
		$decisions = factory(Decision::class, 5)->create();

		foreach ($decisions as $decision) {
			$request = $this->get("/scolarites/eleves/{$decision->document->eleve_id}/documents");

			$request->assertStatus(200);
			$request->assertSee("Gestion des documents");

			$request->assertSee($decision->date_cda->format("d/m/Y"));
			$request->assertSee($decision->date_convention->format("d/m/Y"));
			$request->assertSee($decision->date_limite->format("d/m/Y"));
			$request->assertSee($decision->date_notification->format("d/m/Y"));
		}
	}

	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationDecision()
	{
		$eleve = factory(Eleve::class)->create();
		$request = $this->get("/scolarites/eleves/{$eleve->id}/documents/decisions/create");

		$request->assertStatus(200);
		$request->assertSee("Nouvelle décision");

		$request->assertSee("Date de la CDA");
		$request->assertSee("Date de réception de la notification");
		$request->assertSee("Date limite");
		$request->assertSee("Date de la convention");
		$request->assertSee("Numéro du dossier MDPH");
		$request->assertSee("Nom/prénom de l'enseignant référent");
		$request->assertSee("Fichier");

		$request->assertSee("Ajouter la décision");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationDecisionsIncomplete()
	{
		$eleve = factory(Eleve::class)->create();
		$request = $this->post("/scolarites/eleves/{$eleve->id}/documents/decisions", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Eleve à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */

	public function testTraitementFormulaireCreationDecisionComplete()
	{
		$eleve = factory(Eleve::class)->create();
		factory(TypeDocument::class)->create([
			"libelle" => 'Décision',
		]);

		$request = $this->post("/scolarites/eleves/{$eleve->id}/documents/decisions", [
			"_token"            => csrf_token(),
			"enseignant_id"     => $eleve->enseignant_id,
			"date_cda"          => \Carbon\Carbon::now(),
			"date_notification" => \Carbon\Carbon::now(),
			"date_limite"       => \Carbon\Carbon::now(),
			"date_convention"   => \Carbon\Carbon::now(),
			"numero_dossier"    => "unit.testing",
			"file"              => UploadedFile::fake()->create("avatar.jpg"),
		]);
		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
	}

	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */

	public function testAffichageFormulaireEditionDecision()
	{
		$decision = factory(Decision::class)->create();

		$request = $this->get("/scolarites/eleves/{$decision->document->eleve->id}/documents/decisions/{$decision->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$decision->document->nom}");

		$request->assertSee("Date de la CDA");
		$request->assertSee("Date de réception de la notification");
		$request->assertSee("Date limite");
		$request->assertSee("Date de la convention");
		$request->assertSee("Numéro du dossier MDPH");
		$request->assertSee("Nom/prénom de l'enseignant référent");
		$request->assertSee("Affaire suivie par");
		$request->assertSee("Fichier");

		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la décision à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionDecisionCompleteSansModification()
	{
		$decision = factory(Decision::class)->create();

		$request = $this->put("/scolarites/eleves/{$decision->document->eleve_id}/documents/decisions/{$decision->id}", [
			"_token"            => csrf_token(),
			"enseignant_id"     => $decision->enseignant_id,
			"date_cda"          => $decision->date_cda,
			"date_notification" => $decision->date_notification,
			"date_limite"       => $decision->date_limite,
			"date_convention"   => $decision->date_convention,
			"numero_dossier"    => $decision->numero_dossier,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("decisions", [
			"enseignant_id"     => $decision->enseignant_id,
			"date_cda"          => $decision->date_cda,
			"date_notification" => $decision->date_notification,
			"date_limite"       => $decision->date_limite,
			"date_convention"   => $decision->date_convention,
			"numero_dossier"    => $decision->numero_dossier,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la décision à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionDecisionCompletAvecModification()
	{
		$decision = factory(Decision::class)->create();

		$path = $decision->document->path;
		$date = \Carbon\Carbon::now();

		$request = $this->patch("/scolarites/eleves/{$decision->document->eleve->id}/documents/decisions/{$decision->id}", [
			"_token"            => csrf_token(),
			"enseignant_id"     => $decision->enseignant_id,
			"date_cda"          => $date,
			"date_notification" => $date,
			"date_limite"       => $date,
			"date_convention"   => $date,
			"numero_dossier"    => "unit.testing",
			"file"              => UploadedFile::fake()->create("avatar.jpg"),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("decisions", [
			"enseignant_id"     => $decision->enseignant_id,
			"date_cda"          => $date,
			"date_notification" => $date,
			"date_limite"       => $date,
			"date_convention"   => $date,
			"numero_dossier"    => "unit.testing",
		]);
		$this->assertDatabaseMissing("documents", ["path" => $path]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionDecision()
	{
		$decision = factory(Decision::class)->create();


		$request = $this->get("/scolarites/eleves/{$decision->document->eleve->id}/documents/decisions/{$decision->document->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$decision->document->nom}" . "</b>.");
	}


	/**
	 * Vérifie qu'aucune erreur n'est présente et que la decision à bien été supprimé
	 */
	public function testTraitementSuppressionDecision()
	{
		$decision = factory(Decision::class)->create();

		$request = $this->delete("/scolarites/eleves/{$decision->document->eleve->id}/documents/decisions/{$decision->document->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("documents", ["id" => $decision->id]);
	}

}
