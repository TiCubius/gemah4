<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Materiel;
use Tests\TestCase;

class AffectationsMaterielTest extends TestCase
{
	/**
	 * Vérifie que l'affichage de la recherche de matériel fonctionne
	 */
	public function testAffichageRechercheMateriel()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/affectations/materiels");

		$request->assertStatus(200);
		$request->assertSee("Affectation d'un matériel");
	}

	/**
	 * Vérifie qu'un matériel ne peut pas être affecté à un élève qui le possède déjà
	 */
	public function testAffectationMaterielAffecte()
	{
		$eleve = factory(Eleve::class)->create();
		$materiel = factory(Materiel::class)->create();

		$materiel->update(["eleve_id" => $eleve->id]);

		$request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'un matériel ne peut pas être affecté à un autre élève si il est déjà affecté
	 */
	public function testAffectationMaterielAffecteAutreEleve()
	{
		$eleves = factory(Eleve::class, 2)->create();
		$materiel = factory(Materiel::class)->create();

		$materiel->update(["eleve_id" => $eleves[0]->id]);

		$request = $this->post("/scolarites/eleves/{$eleves[1]->id}/affectations/materiels/{$materiel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'un matériel peut être affecté
	 */
	public function testAffectationMaterielSucces()
	{
		$eleve = factory(Eleve::class)->create();
		$materiel = factory(Materiel::class)->create();

		$request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("materiels", [
			"id"       => $materiel->id,
			"eleve_id" => $eleve->id,
		]);
	}

	/**
	 * Vérifie qu'un matériel ne peut être désaffecté s'il est déjà désaffecté
	 */
	public function testDesaffectationMaterielNonAffecte()
	{
		$eleve = factory(Eleve::class)->create();
		$materiel = factory(Materiel::class)->create();

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'un matériel peut-être désaffecté
	 */
	public function testDesaffectationMateriel()
	{
		$eleve = factory(Eleve::class)->create();
		$materiel = factory(Materiel::class)->create([
			'eleve_id' => $eleve->id,
		]);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");
		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("materiels", [
			"id"       => $materiel->id,
			"eleve_id" => $eleve->id,
		]);
	}
}