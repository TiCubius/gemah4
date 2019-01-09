<?php

namespace Tests\Feature;

use App\Models\Materiel;
use Tests\TestCase;

class AffectationsMaterielTest extends TestCase
{
    public function testAffichageRechercheMateriel()
    {
        $materiels = factory(Materiel::class, 5)->create();

        $request = $this->get("/affectation/materiels");

        $request->assertStatus(200);
        $request->assertSee("Recherche de materiel");

        foreach ($materiels as $materiel) {
            $request->assertSee($materiel->modele);
        }
    }

    public function testAffectationMateriel()
    {
        $this->assertTrue(true);
    }

    public function testDesaffectationMateriel()
    {
        $this->assertTrue(true);
    }
}

?>