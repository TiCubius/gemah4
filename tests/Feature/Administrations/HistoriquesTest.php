<?php

namespace Tests\Feature\Administrations;

use App\Models\Historique;
use Tests\TestCase;

class HistoriquesTest extends TestCase
{
    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexHistoriques()
    {
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type" => "unit.testing",
            "contenue" => "unit.testing",
        ]);
        $request = $this->get("/administrations/historiques");

        $request->assertStatus(200);
        $request->assertSee("Historique");
        $request->assertSee("Type");
        $request->assertSee("Contenue");
        $request->assertSee("Date");
        $request->assertSee("Action");

        $request->assertSee("unit.testing");
    }

    /**
     * Vérifie que l'affichage des informations d'une ligne de l'historique
     */
    public function testAffichageShowHistoriques()
    {
        $historique = Historique::create([
            "from_id" => $this->user->id,
            "type" => "unit.testing",
            "contenue" => "unit.testing",
        ]);

        $request = $this->get("/administrations/historiques/{$historique->id}");

        $request->assertStatus(200);
        $request->assertSee("Détails de l'historique");
        $request->assertSee($historique->type);
        $request->assertSee($historique->contenue);
        $request->assertSee("Effectué par ". $this->user->nom ." ". $this->user->prenom);
    }
}