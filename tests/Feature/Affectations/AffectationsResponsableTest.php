<?php

namespace Tests\Feature;

use App\Models\Eleve;
use App\Models\Responsable;
use Tests\TestCase;

class AffectationsResponsableTest extends TestCase
{
    public function testAffichageRechercheResponsable()
    {
        $responsables = factory(Responsable::class, 5)->create();

        $request = $this->get("/affectation/responsables");

        $request->assertStatus(200);
        $request->assertSee("Recherche de responsable");

        foreach ($responsables as $responsable) {
            $request->assertSee($responsable->nom);
            $request->assertSee($responsable->prenom);
        }
    }


    public function testAffectationResponsableDejaAffecte()
    {
        $responsable = factory(Responsable::class)->create();
        $eleve = factory(Eleve::class)->create();

        $responsable->eleves()->attach($eleve->id);

        $request = $this->post("/affecitation/responsables/{$responsable->id}", [
            "eleve_id" => $eleve->id
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    public function testAffectationResponsableSucces()
    {
        $responsable = factory(Responsable::class)->create();
        $eleve = factory(Eleve::class)->create();

        $request = $this->post("/affectation/responsables/{$responsable->id}", [
            "eleve_id" => $eleve->id
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("eleve_responsable", [
            "eleve_id" => $eleve->id,
            "responsable_id" => $responsable->id
        ]);
    }

    public function testDesaffectationResponsableDejaDesaffecte()
    {
        $responsable = factory(Responsable::class)->create();
        $eleve = factory(Eleve::class)->create();

        $responsable->eleves()->attach($eleve->id);

        $responsable->eleves()->detach($eleve->id);

        $request = $this->post("/desaffectation/responsables/{$responsable->id}", [
            "eleve_id" => $eleve->id
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    public function testDesaffectationResponsable()
    {
        $responsable = factory(Responsable::class)->create();
        $eleve = factory(Eleve::class)->create();

        $responsable->eleves()->attach($eleve->id);

        $request = $this->post("/desaffectation/responsables/{$responsable->id}", [
            "eleve_id" => $eleve->id
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("eleve_responsable", [
            "eleve_id" => $eleve->id,
            "responsable_id" => $responsable->id
        ]);
    }
}

?>