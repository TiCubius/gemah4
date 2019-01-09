<?php

use App\Models\TypeDocument;
use Faker\Generator as Faker;

$factory->define(App\Models\Document::class, function(Faker $faker) {
    $eleve = factory(\App\Models\Eleve::class)->create();
    $type = factory(App\Models\TypeDocument::class)->create();

    return [
        "nom"              => $faker->word,
        "eleve_id"         => $eleve->id,
        "type_document_id" => $type->id,
    ];
});
