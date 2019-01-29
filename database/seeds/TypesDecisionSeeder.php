<?php

use Illuminate\Database\Seeder;

class TypesDecisionSeeder extends Seeder
{
    protected $types = [
        "Matériel",
        "AVS",
    ];

    public function run()
    {
        foreach ($this->types as $type) {
            \App\Models\TypeDecision::create([
                'libelle' => $type,
            ]);
        }
    }
}
