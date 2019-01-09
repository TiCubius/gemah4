<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Decision::class, function (Faker $faker) {
    $eleve = factory(\App\Models\Eleve::class)->create();
    $document = factory(\App\Models\Document::class)->create([
        "type_document_id" => 1
    ]);
    $enseignant = factory(\App\Models\Enseignant::class)->create();

    return [
        "eleve_id" => $eleve->id,
        "document_id" => $document->id,
        "enseignant_id" => $enseignant->id,
        "date_cda" => $faker->date,
        "date_notif" => $faker->date,
        "date_limite" => $faker->date,
        "date_convention" => $faker->date,
        "numero_dossier" => $faker->randomNumber(6,true),
        "nom_suivi" => $faker->word,
    ];
});
