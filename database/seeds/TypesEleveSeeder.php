<?php

use Illuminate\Database\Seeder;

class TypesEleveSeeder extends Seeder
{
    protected $types = [
        "Matériel",
        "AVS",
    ];

    public function run()
    {
        foreach ($this->types as $type) {
            \App\Models\TypeEleve::create([
                'libelle' => $type,
            ]);
        }
    }
}
