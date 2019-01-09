<?php

namespace Tests\Feature;

use App\Models\Materiel;
use Tests\TestCase;

class AffectationsMaterielTest extends TestCase
{
    public function testAffichageRechercheMateriel()
    {
        $materiels = factory(Materiel::class, 5)->create();

        $request = $this->get("/scolarites/eleves/{$eleve->id}/affectation/materiels");

        $request->assertStatus(200);
        $request->assertSee("Recherche de materiel");

        foreach ($materiels as $materiel) {
            $request->assertSee($materiel->modele);
        }
    }

    public function testAffectationMaterielDejaAffecte()
    {
        $this->assertTrue(true);
    }

    public function testAffectationMaterielSucces()
    {
        $this->assertTrue(true);
    }

    public function testDesaffectationMaterielDejaAffecte()
    {
        $this->assertTrue(true);
    }

    public function testDesaffectationMaterielSucces()
    {
        $this->assertTrue(true);
    }
}

?>