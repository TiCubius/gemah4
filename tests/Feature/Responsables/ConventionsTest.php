<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Responsable;
use Carbon\Carbon;
use ParametresSeeders;
use Tests\TestCase;

class ConventionsTest extends TestCase
{
	/***
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexConventions()
	{
		$this->seed(ParametresSeeders::class);
		$responsable = factory(Responsable::class)->create();
		$eleve = factory(Eleve::class)->create();

		$responsable->eleves()->attach($eleve);

		$request = $this->get("/conventions");

		$request->assertStatus(200);
		$request->assertSee("Liste des conventions");
		$request->assertSee("{$eleve->nom} {$eleve->prenom}");
		$request->assertSee("{$responsable->nom} {$responsable->prenom}");
	}

	/***
	 * Vérifie que le traitement d'un formulaire sans modification fonctionne.
	 */
	public function testTraitementFormulaireSansModificationConventions()
	{
		$eleve = factory(Eleve::class)->create();
		$responsables = factory(Responsable::class, 2)->create();

		$responsables[0]->eleves()->attach($eleve);

		$request = $this->patch("/conventions/");

		$request->assertStatus(302);
		$this->assertDatabaseHas("eleve_responsable", [
			"eleve_id"       => $eleve->id,
			"responsable_id" => $responsables[0]->id,
			"etat_signature" => 0,
			"date_signature" => null,
		]);
	}

	/***
	 * Vérifie que le traitement d'un formulaire avec modification fonctionne.
	 */
	public function testTraitementFormulaireAvecModificationConventions()
	{
		$eleve = factory(Eleve::class)->create();
		$responsables = factory(Responsable::class, 2)->create();

		$responsables[0]->eleves()->attach($eleve, [
			"etat_signature" => 1,
			"date_signature" => Carbon::now(),
		]);

		$request = $this->patch("/conventions/");

		$request->assertStatus(302);
		$this->assertDatabaseHas("eleve_responsable", [
			"eleve_id"       => $eleve->id,
			"responsable_id" => $responsables[0]->id,
			"etat_signature" => 0,
			"date_signature" => null,
		]);
	}
}