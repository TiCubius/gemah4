<?php

namespace Tests\Feature\Scolarites\Affectations;

use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Responsable;
use Tests\TestCase;

class AffectationsResponsableTest extends TestCase
{
	/**
	 * Vérifie que la page de recherche fonctionne
	 */
	public function testAffichageRechercheResponsable()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/affectations/responsables");

		$request->assertStatus(200);
		$request->assertSee("Affectation d'un responsable");
	}


	/**
	 * Vérifie qu'un message d'erreur apparait lors de l'affectation d'un responsable à un élève qui lui est déjà affecté
	 */
	public function testAffectationResponsableDejaAffecte()
	{
		$responsable = factory(Responsable::class)->create();
		$eleve = factory(Eleve::class)->create();

		$responsable->eleves()->attach($eleve);

		$request = $this->patch("/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que l'affectation d'un responsable fonctionne
	 */
	public function testAffectationResponsableSucces()
	{
		$responsable = factory(Responsable::class)->create();
		$eleve = factory(Eleve::class)->create();

		$request = $this->patch("/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleve_responsable", [
			"eleve_id"       => $eleve->id,
			"responsable_id" => $responsable->id,
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id"   => $this->user->id,
            "type"      => "responsable/affectation",
            "information"  => "Le responsable {$responsable->nom} {$responsable->prenom} à été affecté à l'élève {$eleve->nom} {$eleve->prenom} par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie que l'affectation d'un responsable fonctionne
	 */
	public function testAffectationResponsableAutoAffectation()
	{
		$departement = factory(Departement::class)->create();
		$eleve = factory(Eleve::class)->create();

		$request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/responsables/", [
			"_token"         => csrf_token(),
			"civilite"       => "M.",
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"departement_id" => $departement->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleve_responsable", [
			"eleve_id"       => $eleve->id,
			"responsable_id" => Responsable::where('nom', 'unit.testing')->first()->id,
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id"   => $this->user->id,
            "type"      => "responsable/affectation",
            "information"  => "Le responsable unit.testing unit.testing à été affecté à l'élève {$eleve->nom} {$eleve->prenom} par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'un message d'erreur apparait lors de la désaffectation d'un responsable à un élève qui ne lui est pas affecté
	 */
	public function testDesaffectationResponsableDejaDesaffecte()
	{
		$responsable = factory(Responsable::class)->create();
		$eleve = factory(Eleve::class)->create();

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
        $this->assertDatabaseMissing("historiques", [
            "from_id"   => $this->user->id,
            "type"      => "responsable/desaffectation",
            "information"  => "Le responsable {$responsable->nom} {$responsable->prenom} à été désaffecté de l'élève {$eleve->nom} {$eleve->prenom} par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie que la désaffectation d'un responsable fonctionne
	 */
	public function testDesaffectationResponsable()
	{
		$responsable = factory(Responsable::class)->create();
		$eleve = factory(Eleve::class)->create();

		$responsable->eleves()->attach($eleve);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleve_responsable", [
			"eleve_id"       => $eleve->id,
			"responsable_id" => $responsable->id,
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id"   => $this->user->id,
            "type"      => "responsable/desaffectation",
            "information"  => "Le responsable {$responsable->nom} {$responsable->prenom} à été désaffecté de l'élève {$eleve->nom} {$eleve->prenom} par {$this->user->nom} {$this->user->prenom}"
        ]);
	}
}