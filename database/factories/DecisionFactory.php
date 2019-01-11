<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Decision::class, function (Faker $faker) {
    $document = factory(\App\Models\Document::class)->create([
        "type_document_id" => 1,
    ]);
    $enseignant = factory(\App\Models\Enseignant::class)->create();

    return [
        "eleve_id" => $document->eleve_id,
        "document_id" => $document->id,
        "enseignant_id" => $enseignant->id,
        "date_cda" => $faker->dateTime,
        "date_notif" => $faker->dateTime,
        "date_limite" => $faker->dateTime,
        "date_convention" => $faker->dateTime,
        "numero_dossier" => $faker->randomNumber(6,true),
        "nom_suivi" => $faker->word,
    ];
});
