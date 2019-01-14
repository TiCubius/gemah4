<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Departement::class, function(Faker $faker) {
    $academie = factory(\App\Models\Academie::class)->create();

    return [
        "id"        => $faker->name,
        "nom"       => $faker->word,
        "academie_id" => $academie->id,
    ];
});
