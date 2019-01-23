<?php

use Illuminate\Database\Seeder;

class EtatsPhysiquesMaterielSeeder extends Seeder
{
    private $etats = [
        "Bon état",
        "Mauvais état",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->etats as $etat) {
            \App\Models\EtatPhysiqueMateriel::create([
                "libelle" => $etat,
            ]);
        }
    }
}
