<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Etablissement;
use Tests\TestCase;

class AffectationsEtablissementlTest extends TestCase
{
	/**
	 * Vérifie que l'affichage de la recherche de établissement fonctionne
	 */
	public function testAffichageRechercheEtablissement()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/affectations/etablissements");

		$request->assertStatus(200);
		$request->assertSee("Affectation d'un établissement");
	}

	/**
	 * Vérifie qu'un établissement ne peut pas être affecté à un élève qui le possède déjà
	 */
	public function testAffectationEtablissementAffecte()
	{
		$etablissement = factory(Etablissement::class)->create();
		$eleve = factory(Eleve::class)->create([
			"etablissement_id" => $etablissement->id,
		]);

		$request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'un établissement peut être affecté
	 */
	public function testAffectationEtablissementSucces()
	{
		$eleve = factory(Eleve::class)->create();
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", [
			"id"               => $eleve->id,
			"etablissement_id" => $etablissement->id,
		]);
	}

	/**
	 * Vérifie qu'un établissement ne peut être désaffecté s'il est déjà désaffecté
	 */
	public function testDesaffectationEtablissementNonAffecte()
	{
		$eleve = factory(Eleve::class)->create();
		$etablissement = factory(Etablissement::class)->create();

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'un établissement peut-être désaffecté
	 */
	public function testDesaffectationEtablissement()
	{
		$etablissement = factory(Etablissement::class)->create();
		$eleve = factory(Eleve::class)->create([
			"etablissement_id" => $etablissement->id,
		]);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/etablissements/{$etablissement->id}");
		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleves", [
			"id"               => $eleve->id,
			"etablissement_id" => $etablissement->id,
		]);
	}
}