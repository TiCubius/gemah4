<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Materiel;
use Tests\TestCase;

class AffectationsMaterielTest extends TestCase
{
    public function testAffichageRechercheMateriel()
    {
        $eleve = factory(Eleve::class)->create();
        $materiels = factory(Materiel::class, 5)->create();

        $request = $this->get("/scolarites/eleves/{$eleve->id}/affectations/materiels");

        $request->assertStatus(200);
        $request->assertSee("Affectation d'un matériel");

        foreach ($materiels as $materiel) {
            $request->assertSee($materiel->modele);
        }
    }

    public function testAffectationMaterielDejaAffecte()
    {
        $eleve = factory(Eleve::class)->create();
        $materiel = factory(Materiel::class)->create();

        $materiel->update(["eleve_id" => $eleve->id]);

        $request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    public function testAffectationMaterielSucces()
    {
        $eleve = factory(Eleve::class)->create();
        $materiel = factory(Materiel::class)->create();

        $request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("materiels", [
            "id" => $materiel->id,
            "eleve_id" => $eleve->id
        ]);

    }

    public function testDesaffectationMaterielDejaAffecte()
    {
        $eleve = factory(Eleve::class)->create();
        $materiel = factory(Materiel::class)->create();

        $materiel->update(["eleve_id" => $eleve->id]);
        $materiel->update(["eleve_id" => NULL]);

        $request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    public function testDesaffectationMaterielSucces()
    {
        $eleve = factory(Eleve::class)->create();
        $materiel = factory(Materiel::class)->create();

        $materiel->update(["eleve_id" => $eleve->id]);

        $request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("materiels", [
            "id" => $materiel->id,
            "eleve_id" => $eleve->id
        ]);
    }
}

?>